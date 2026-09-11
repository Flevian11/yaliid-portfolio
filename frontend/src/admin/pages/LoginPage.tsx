import { useState, type FormEvent } from 'react';
import { Eye, EyeOff, KeyRound, ShieldCheck, XCircle, ArrowRight } from 'lucide-react';
import { useNavigate } from 'react-router-dom';
import { api } from '../../api';

export default function LoginPage() {
  const [key,setKey]=useState(''); const [show,setShow]=useState(false); const [loading,setLoading]=useState(false);
  const [error,setError]=useState(''); const nav=useNavigate();

  const submit=async(e:FormEvent)=>{e.preventDefault();if(!key.trim())return;setLoading(true);setError('');
    try { await api.post('/auth/login',{key:key.trim()}); await api.get('/auth/me'); nav('/admin',{replace:true}); }
    catch(e:any){const status=e?.response?.status;setError(status===422?'Please enter a valid administrator key.':status===401?'Invalid administrator key.':status===419?'Your security session expired. Refresh and try again.':e?.response?.data?.message||'We could not authenticate you. Please try again.');}
    finally{setLoading(false);}
  };

  return <main className="login">
    <div className="login-shell">
      <section className="login-brand">
        <div className="login-brand__top"><div className="login-brand__mark">TG</div><div><b>Tech<span>Ghost</span></b><small>ADMIN PORTAL</small></div></div>
        <div className="login-brand__content"><span className="login-eyebrow"><ShieldCheck size={15}/> SECURE ADMIN ACCESS</span><h1>Control the work<br/><em>behind the portfolio.</em></h1><p>Manage portfolio content, credentials, projects, services and incoming requests from one protected workspace.</p></div>
        <div className="login-status"><i/><div><b>Private workspace</b><span>Authorized access only</span></div></div>
      </section>
      <section className="login-form-panel">
        <div className="login-form-top"><span>ADMINISTRATOR</span><span>01</span></div>
        <form onSubmit={submit}>
          <div className="login-title"><small>WELCOME BACK</small><h2>Sign in to<br/>your workspace.</h2><p>Enter your administrator key to continue.</p></div>
          {error&&<div className="login-error"><XCircle size={18}/><div><b>Access denied</b><span>{error}</span></div></div>}
          <label className={`login-key ${error?'has-error':''}`}><span>Administrator key</span><div><KeyRound size={18}/><input value={key} onChange={e=>{setKey(e.target.value);if(error)setError('')}} placeholder="Enter your key" type={show?'text':'password'} autoComplete="current-password" autoFocus required/><button type="button" onClick={()=>setShow(!show)} aria-label={show?'Hide key':'Show key'}>{show?<EyeOff size={18}/>:<Eye size={18}/>}</button></div></label>
          <button className="login-submit" disabled={loading||!key.trim()}>{loading?<><span className="button-spinner"/> Authenticating…</>:<>Enter admin portal <ArrowRight size={17}/></>}</button>
          <div className="login-security"><ShieldCheck size={15}/><span>Protected by authenticated session access.</span></div>
        </form>
      </section>
    </div>
  </main>;
}
