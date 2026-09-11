import { useEffect, useMemo, useState, type FormEvent } from 'react';
import { Pencil, Plus, Trash2, FileText } from 'lucide-react';
import { api } from '../../api';
import type { ResourceConfig, Field } from '../resourceConfig';
import AdminPage from '../components/AdminPage';
import EmptyState from '../components/EmptyState';
import FeedbackModal, { ConfirmModal } from '../components/FeedbackModal';

function rowsFrom(payload: any): any[] {
  if (Array.isArray(payload)) return payload;
  if (Array.isArray(payload?.data)) return payload.data;
  return [];
}
function dateValue(value: unknown) {
  return value ? String(value).slice(0, 10) : '';
}
function errorMessage(e: any, fallback: string) {
  const errors = e?.response?.data?.errors;
  if (errors) return Object.values(errors).flat().join(' ');
  return e?.response?.data?.message || fallback;
}

export default function ResourcePage({ config }: { config: ResourceConfig }) {
  const [rows, setRows] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const [editing, setEditing] = useState<any | null>(null);
  const [confirm, setConfirm] = useState<any | null>(null);
  const [feedback, setFeedback] = useState<{ kind: 'success'|'error'; title: string; message: string } | null>(null);

  const load = async () => {
    setLoading(true);
    try {
      const response = await api.get(config.endpoint);
      setRows(rowsFrom(response.data));
    } catch (e: any) {
      setFeedback({ kind: 'error', title: `Couldn't load ${config.title.toLowerCase()}`, message: errorMessage(e, 'The records could not be retrieved. Please try again.') });
    } finally {
      setLoading(false);
    }
  };
  useEffect(() => { void load(); }, [config.endpoint]);

  const remove = async () => {
    if (!confirm) return;
    try {
      await api.delete(`${config.endpoint}/${confirm.id}`);
      setConfirm(null);
      await load();
      setFeedback({ kind: 'success', title: 'Record deleted', message: `${config.singular} was permanently removed from the portfolio.` });
    } catch (e: any) {
      setConfirm(null);
      setFeedback({ kind: 'error', title: 'Delete failed', message: errorMessage(e, 'The record could not be deleted.') });
    }
  };

  return (
    <AdminPage
      eyebrow="CONTENT MANAGEMENT"
      title={config.title}
      description={`Manage the ${config.title.toLowerCase()} displayed across the public portfolio.`}
      action={!config.createDisabled ? <button className="admin-action" onClick={() => setEditing({ __new: true })}><Plus size={16} /> Add {config.singular}</button> : undefined}
    >
      <div className="admin-panel">
        {loading ? <div className="admin-table-loading"><span className="spinner" /> Loading {config.title.toLowerCase()}…</div> :
          rows.length ? <div className="record-list">{rows.map((row) => <RecordRow key={row.id} row={row} config={config} onEdit={() => setEditing(row)} onDelete={() => setConfirm(row)} />)}</div> :
          <EmptyState icon={config.icon} title={`No ${config.title.toLowerCase()} yet`} description={`There are no ${config.title.toLowerCase()} records to manage. Add one to publish it on the portfolio.`} action={!config.createDisabled ? <button className="admin-button primary" onClick={() => setEditing({ __new: true })}><Plus size={15} /> Add {config.singular}</button> : undefined} />}
      </div>

      {editing && <EditorModal config={config} item={editing.__new ? null : editing} onClose={() => setEditing(null)} onSaved={async () => { setEditing(null); await load(); setFeedback({ kind:'success', title: 'Changes saved', message: `${config.singular} was saved successfully.` }); }} />}
      {confirm && <ConfirmModal title={`Delete this ${config.singular}?`} message="This action permanently removes the record. It cannot be undone." confirmLabel="Delete permanently" danger onCancel={() => setConfirm(null)} onConfirm={remove} />}
      {feedback && <FeedbackModal kind={feedback.kind} title={feedback.title} message={feedback.message} onClose={() => setFeedback(null)} />}
    </AdminPage>
  );
}

function RecordRow({ row, config, onEdit, onDelete }: { row:any; config:ResourceConfig; onEdit:()=>void; onDelete:()=>void }) {
  const Icon = config.icon;
  const title = row.full_name || row.name || row.title || row.organization || row.institution || row.subject || `#${row.id}`;
  const subtitle = row.position || row.issuing_organization || row.field_of_study || row.email || row.slug || '';
  return (
    <div className="record-row">
      <div className="record-icon"><Icon size={18} /></div>
      <div className="record-main"><b>{title}</b><span>{subtitle}</span>{row.description && <small>{String(row.description).slice(0, 160)}</small>}</div>
      <div className="record-meta">
        {row.is_published !== undefined && <span className={`status status-${row.is_published ? 'published' : 'draft'}`}>{row.is_published ? 'Published' : 'Draft'}</span>}
        {row.certificate_file && <span className="file-chip"><FileText size={12}/> Certificate</span>}
        {row.file_name && <span className="file-chip"><FileText size={12}/> {row.file_name}</span>}
      </div>
      <div className="record-actions">
        <button onClick={onEdit} title="Edit"><Pencil size={15}/></button>
        {!config.createDisabled && <button onClick={onDelete} title="Delete" className="danger"><Trash2 size={15}/></button>}
      </div>
    </div>
  );
}

function EditorModal({ config, item, onClose, onSaved }: { config:ResourceConfig; item:any|null; onClose:()=>void; onSaved:()=>void }) {
  const initial = useMemo(
    () => Object.fromEntries(
      config.fields
        .filter(f => f.type !== 'file')
        .map(f => [f.key, item?.[f.key] ?? (f.type === 'checkbox' ? false : '')])
    ),
    [config, item]
  );
  const [form, setForm] = useState<any>(initial);
  const [files, setFiles] = useState<Record<string, File|undefined>>({});
  const [removeFile, setRemoveFile] = useState(false);
  const [lookupOptions, setLookupOptions] = useState<Record<string, { value:string|number; label:string }[]>>({});
  const [saving, setSaving] = useState(false);
  const [feedback, setFeedback] = useState<string | null>(null);

  useEffect(() => {
    let active = true;
    const fields = config.fields.filter(field => field.type === 'select' && field.optionsEndpoint);
    if (!fields.length) {
      setLookupOptions({});
      return;
    }

    Promise.all(fields.map(async field => {
      const response = await api.get(field.optionsEndpoint!);
      const values = rowsFrom(response.data).map((option:any) => ({
        value: option.value ?? option.id,
        label: option.label ?? option.name ?? option.title ?? String(option.id),
      }));
      return [field.key, values] as const;
    }))
      .then(entries => {
        if (active) setLookupOptions(Object.fromEntries(entries));
      })
      .catch(() => {
        if (active) setFeedback('Some selection options could not be loaded. Please close and reopen this form.');
      });

    return () => { active = false; };
  }, [config]);

  const set = (key:string, value:any) => setForm((old:any) => ({...old, [key]:value}));

  const submit = async (event:FormEvent) => {
    event.preventDefault(); setSaving(true);
    try {
      const hasFiles = Object.values(files).some(Boolean);
      if (hasFiles || config.fileField) {
        const fd = new FormData();
        Object.entries(form).forEach(([key,value]) => {
          if (value !== '' && value !== null && value !== undefined) {
            fd.append(key, typeof value === 'boolean' ? (value ? '1':'0') : String(value));
          }
        });
        Object.entries(files).forEach(([key,file]) => { if (file) fd.append(key,file); });
        if (removeFile && config.fileField) {
          fd.append(config.fileField === 'certificate_file' ? 'remove_certificate_file' : 'remove_file', '1');
        }
        if (item) fd.append('_method','PUT');
        await api.post(item ? `${config.endpoint}/${item.id}` : config.endpoint, fd, {headers:{'Content-Type':'multipart/form-data'}});
      } else if (item) {
        await api.put(`${config.endpoint}/${item.id}`, form);
      } else {
        await api.post(config.endpoint, form);
      }
      await onSaved();
    } catch (e:any) {
      setFeedback(errorMessage(e,'Could not save these changes.'));
    } finally {
      setSaving(false);
    }
  };

  return (
    <>
    <div className="modal-backdrop" onClick={(event) => { if (event.target === event.currentTarget) onClose(); }}>
      <div className="admin-modal admin-modal--large">
        <div className="modal-head">
          <div><small>{item ? 'EDIT RECORD' : 'NEW RECORD'}</small><h2>{item ? 'Edit' : 'Add'} {config.singular}</h2><p>Update the information used by the public portfolio.</p></div>
          <button className="modal-close" onClick={onClose} aria-label="Close">×</button>
        </div>

        <form className="admin-form" onSubmit={submit}>
          <div className="form-grid">
            {config.fields.map(field => (
              <FieldInput
                key={field.key}
                field={field}
                value={form[field.key]}
                onChange={v=>set(field.key,v)}
                existingFile={item?.[field.key]}
                onFile={file=>setFiles(old=>({...old,[field.key]:file}))}
                lookupOptions={lookupOptions[field.key] || []}
              />
            ))}
          </div>
          {item && config.fileField && config.removableFile !== false && (item[config.fileField] || item.file_name) && (
            <label className="remove-file">
              <input type="checkbox" checked={removeFile} onChange={e=>setRemoveFile(e.target.checked)}/>
              Remove current file
            </label>
          )}
          <div className="modal-actions">
            <button type="button" className="admin-button secondary" onClick={onClose}>Cancel</button>
            <button type="submit" className="admin-button primary" disabled={saving}>
              {saving ? <><span className="button-spinner"/> Saving…</> : 'Save changes'}
            </button>
          </div>
        </form>
      </div>
    </div>
    {feedback && <FeedbackModal kind="error" title="Could not save changes" message={feedback} onClose={() => setFeedback(null)} />}
    </>
  );
}

function FieldInput({
  field,
  value,
  onChange,
  onFile,
  existingFile,
  lookupOptions = [],
}: {
  field:Field;
  value:any;
  onChange:(v:any)=>void;
  onFile:(f?:File)=>void;
  existingFile?:string;
  lookupOptions?:{value:string|number;label:string}[];
}) {
  if (field.type === 'checkbox') {
    return <label className="check-field"><input type="checkbox" checked={Boolean(value)} onChange={e=>onChange(e.target.checked)}/><span>{field.label}</span></label>;
  }

  if (field.type === 'file') {
    return (
      <label className="field">
        <span>{field.label}</span>
        {existingFile && <small className="existing-file">Current: {String(existingFile).split('/').pop()}</small>}
        <input type="file" accept={field.accept} onChange={e=>onFile(e.target.files?.[0])}/>
      </label>
    );
  }

  if (field.type === 'textarea') {
    return <label className="field wide"><span>{field.label}</span><textarea value={value ?? ''} required={field.required} onChange={e=>onChange(e.target.value)} rows={5}/></label>;
  }

  if (field.type === 'select') {
    const options = field.optionsEndpoint ? lookupOptions : (field.options || []).map(option => ({value: option, label: option}));
    return (
      <label className="field">
        <span>{field.label}</span>
        <select value={value ?? ''} required={field.required} onChange={e=>onChange(e.target.value === '' ? '' : e.target.value)}>
          {!field.required && <option value="">Not specified</option>}
          {field.required && !value && <option value="">Select {field.label.toLowerCase()}</option>}
          {options.map(option => <option key={String(option.value)} value={String(option.value)}>{option.label}</option>)}
        </select>
      </label>
    );
  }

  return <label className="field"><span>{field.label}</span><input type={field.type || 'text'} value={field.type==='date' ? dateValue(value) : value ?? ''} required={field.required} onChange={e=>onChange(field.type==='number' ? (e.target.value===''?'':Number(e.target.value)) : e.target.value)}/></label>;
}
