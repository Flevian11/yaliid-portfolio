import { useState, type FormEvent } from 'react';
import { CheckCircle2, KeyRound, ShieldCheck } from 'lucide-react';
import { api } from '../../api';
import AdminPage from '../components/AdminPage';
import FeedbackModal from '../components/FeedbackModal';

export default function SecurityPage() {
  const [current,setCurrent]=useState(''); const [next,setNext]=useState(''); const [confirm,setConfirm]=useState('');
  const [saving,setSaving]=useState(false); const [feedback,setFeedback]=useState<any>(null);

  const submit=async(e:FormEvent)=>{e.preventDefault();setSaving(true);try{
    await api.post('/auth/change-key',{current_key:current,new_key:next,new_key_confirmation:confirm});
    setCurrent('');setNext('');setConfirm('');
    setFeedback({kind:'success',title:'Admin key changed',message:'Your new administrator key is now active. Keep it somewhere secure.'});
  }catch(err:any){setFeedback({kind:'error',title:'Could not change key',message:err?.response?.data?.message||'The administrator key could not be changed.'});}finally{setSaving(false);}};
  return <AdminPage eyebrow="SECURITY" title="Admin Access" description="Protect the workspace with a private administrator key.">
    <div className="security-layout">
      <div className="security-intro admin-panel"><div className="security-icon"><ShieldCheck size={28}/></div><small>PROTECTED WORKSPACE</small><h2>Keep your portfolio secure.</h2><p>The administrator key is stored as a secure hash. It is never displayed or recoverable from the portal.</p><div className="security-points"><span><CheckCircle2 size={15}/> Key is never shown after saving</span><span><CheckCircle2 size={15}/> Authenticated session required</span><span><CheckCircle2 size={15}/> Change it whenever necessary</span></div></div>
      <form className="security-card admin-panel security-form" onSubmit={submit}><div className="security-form__head"><KeyRound size={21}/><div><h2>Change access key</h2><p>Use a new key you can keep secure.</p></div></div>
        <label className="field"><span>Current key</span><input type="password" value={current} onChange={e=>setCurrent(e.target.value)} required autoComplete="current-password"/></label>
        <label className="field"><span>New key</span><input type="password" value={next} onChange={e=>setNext(e.target.value)} minLength={4} required autoComplete="new-password"/></label>
        <label className="field"><span>Confirm new key</span><input type="password" value={confirm} onChange={e=>setConfirm(e.target.value)} minLength={4} required autoComplete="new-password"/></label>
        <button className="admin-button primary" disabled={saving}>{saving?<><span className="button-spinner"/> Updating…</>:'Change admin key'}</button>
      </form>
    </div>
    {feedback&&<FeedbackModal kind={feedback.kind} title={feedback.title} message={feedback.message} onClose={()=>setFeedback(null)}/>}
  </AdminPage>;
}
