import { useEffect, useState } from 'react';
import { Inbox, MessageSquare, Trash2, Mail, Clock3, Building2, Banknote, CalendarDays, Flag } from 'lucide-react';
import AdminPage from '../components/AdminPage';
import EmptyState from '../components/EmptyState';
import FeedbackModal, { ConfirmModal } from '../components/FeedbackModal';
import { api } from '../../api';

function formatDate(value:any){return value ? String(value).slice(0,10) : '—';}
function friendlyError(error: any, fallback: string) {
  const status = error?.response?.status;
  if (status === 404) {
    return 'This item is no longer available. The list has been refreshed to show the latest information.';
  }
  if (status === 422) {
    return 'Some of the information could not be saved. Please check the fields and try again.';
  }
  if (status === 401 || status === 419) {
    return 'Your admin session has expired. Please sign in again.';
  }
  return fallback;
}

export default function InboxPages({mode}:{mode:'requests'|'messages'}) {
  const isRequests = mode === 'requests';
  const [rows,setRows]=useState<any[]>([]);
  const [selected,setSelected]=useState<any|null>(null);
  const [feedback,setFeedback]=useState<any>(null);
  const [confirm,setConfirm]=useState(false);
  const load=async()=>{try{const r=await api.get(isRequests?'/admin/service-requests':'/admin/messages');setRows(Array.isArray(r.data)?r.data:(r.data?.data||[]));}catch(e:any){setFeedback({kind:'error',title:'Could not load inbox',message:friendlyError(e,'The inbox could not be loaded. Please try again.')});}};
  useEffect(()=>{void load();},[mode]);

  const open=async(id:number)=>{try{const r=await api.get(`${isRequests?'/admin/service-requests':'/admin/messages'}/${id}`);setSelected(r.data);if(!isRequests){const row=rows.find(x=>x.id===id);if(row?.status==='unread') await api.patch(`/admin/messages/${id}`,{status:'read'});}}catch(e:any){if(e?.response?.status===404){setSelected(null);await load();}setFeedback({kind:'error',title:'Could not open this item',message:friendlyError(e,'We could not open this item right now. Please try again.')});}};
  const update=async(patch:any)=>{if(!selected)return;try{const r=await api.patch(`${isRequests?'/admin/service-requests':'/admin/messages'}/${selected.id}`,patch);setSelected(r.data);await load();setFeedback({kind:'success',title:'Updated successfully',message:isRequests?'The service request has been updated.':'The message status has been updated.'});}catch(e:any){if(e?.response?.status===404){setSelected(null);await load();}setFeedback({kind:'error',title:isRequests?'Couldn’t update request':'Couldn’t update message',message:friendlyError(e,isRequests?'We couldn’t save that request. It may have been removed or is no longer available.':'We couldn’t save that message right now. Please try again.')});}};
  const remove=async()=>{if(!selected)return;try{await api.delete(`${isRequests?'/admin/service-requests':'/admin/messages'}/${selected.id}`);setSelected(null);setConfirm(false);await load();setFeedback({kind:'success',title:'Deleted successfully',message:`The ${isRequests?'service request':'message'} was permanently removed.`});}catch(e:any){setConfirm(false);if(e?.response?.status===404){setSelected(null);await load();}setFeedback({kind:'error',title:`Couldn’t delete ${isRequests?'request':'message'}`,message:friendlyError(e,`We couldn’t delete this ${isRequests?'request':'message'} right now. Please try again.`)});}};

  return <AdminPage eyebrow="INBOX" title={isRequests?'Service Requests':'Contact Messages'} description={isRequests?'Review, prioritize and manage incoming project enquiries.':'Read and manage messages sent through the portfolio contact form.'}>
    <div className="inbox-layout">
      <div className={`admin-panel inbox-list ${isRequests ? 'inbox-list--requests' : 'inbox-list--messages'}`}>
        {rows.length ? rows.map(x=><button className={`inbox-item ${selected?.id===x.id?'selected':''}`} key={x.id} onClick={()=>void open(x.id)}>
          <div className="inbox-item__avatar">{isRequests?<Inbox size={16}/>:<Mail size={16}/>}</div>
          <div className="inbox-item__body"><b>{x.reference || x.subject || x.name}</b><span>{isRequests ? (x.company || x.name) : x.name}</span><small>{x.email} · {formatDate(x.created_at)}</small></div>
          <span className={`status status-${String(x.status||'new').replaceAll('_','-')}`}>{String(x.status||'new').replaceAll('_',' ')}</span>
        </button>) : <EmptyState icon={isRequests?Inbox:MessageSquare} title={isRequests?'No service requests yet':'Your inbox is empty'} description={isRequests?'New project enquiries will appear here.':'New contact messages will appear here.'}/>}
      </div>
      {selected ? <Detail item={selected} requests={isRequests} onUpdate={update} onDelete={()=>setConfirm(true)}/> :
        <div className="admin-panel detail-empty"><div className="detail-empty__icon">{isRequests?<Inbox size={28}/>:<MessageSquare size={28}/>}</div><b>{isRequests?'Select a request':'Select a message'}</b><span>{isRequests?'Choose a request from the list to review its details.':'Choose a message from the list to read the full conversation.'}</span></div>}
    </div>
    {confirm && <ConfirmModal title={`Delete this ${isRequests?'request':'message'}?`} message="This action permanently removes the item and cannot be undone." confirmLabel="Delete permanently" danger onCancel={()=>setConfirm(false)} onConfirm={()=>void remove()}/>}
    {feedback && <FeedbackModal kind={feedback.kind} title={feedback.title} message={feedback.message} onClose={()=>setFeedback(null)}/>}
  </AdminPage>;
}

function Detail({item,requests,onUpdate,onDelete}:{item:any;requests:boolean;onUpdate:(p:any)=>Promise<void>;onDelete:()=>void}) {
  return <div className="admin-panel detail-panel">
    <div className="detail-head"><div><small>{item.reference || item.email}</small><h2>{requests?item.name:item.subject}</h2><span>{requests?`${item.email}${item.phone?` · ${item.phone}`:''}`:item.name}</span></div><span className={`status status-${String(item.status||'new').replaceAll('_','-')}`}>{String(item.status||'new').replaceAll('_',' ')}</span></div>
    {requests ? <><div className="detail-grid"><DetailItem icon={Inbox} label="Service" value={item.service?.name}/><DetailItem icon={Building2} label="Company" value={item.company}/><DetailItem icon={Banknote} label="Budget" value={item.budget?`KES ${item.budget}`:'Not specified'}/><DetailItem icon={CalendarDays} label="Preferred deadline" value={formatDate(item.preferred_deadline)}/><DetailItem icon={Flag} label="Priority" value={item.priority}/><DetailItem icon={Clock3} label="Received" value={formatDate(item.created_at)}/></div><div className="detail-block detail-block--request"><small>REQUEST DETAILS</small><div className="request-content"><p>{item.description || 'No additional request details were provided.'}</p></div></div><div className="detail-actions"><select value={item.status} onChange={e=>void onUpdate({status:e.target.value})}><option>new</option><option>reviewing</option><option>quoted</option><option>approved</option><option>in_progress</option><option>completed</option><option>cancelled</option></select><select value={item.priority} onChange={e=>void onUpdate({priority:e.target.value})}><option>low</option><option>normal</option><option>high</option></select><button className="icon-button danger" onClick={onDelete}><Trash2 size={16}/></button></div></> :
    <><div className="detail-block detail-block--message"><small>MESSAGE</small><div className="message-content"><p className="message-body">{item.message || 'No message content was provided.'}</p></div></div><div className="detail-actions"><select value={item.status} onChange={e=>void onUpdate({status:e.target.value})}><option>unread</option><option>read</option><option>archived</option></select><button className="icon-button danger" onClick={onDelete}><Trash2 size={16}/></button></div></>}
  </div>;
}
function DetailItem({icon:Icon,label,value}:{icon:any;label:string;value:any}){return <div><Icon size={15}/><small>{label}</small><b>{value||'—'}</b></div>;}
