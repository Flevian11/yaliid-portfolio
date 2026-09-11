import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { ArrowRight, Award, BarChart3, BriefcaseBusiness, ChevronRight, Database, FileText, FolderKanban, GraduationCap, MessageSquare, Sparkles, Wrench } from 'lucide-react';
import { api } from '../../api';
import AdminPage, { PanelTitle } from '../components/AdminPage';
import EmptyState from '../components/EmptyState';
import FeedbackModal from '../components/FeedbackModal';

const statDefs = [
  ['Total Projects', 'projects', FolderKanban, 'project', '/admin/projects'],
  ['Work Experience', 'experiences', BriefcaseBusiness, 'experience', '/admin/experience'],
  ['Education', 'education', GraduationCap, 'education records', '/admin/education'],
  ['Certifications', 'certifications', Award, 'certifications', '/admin/certifications'],
  ['Services', 'services', Wrench, 'services', '/admin/services'],
  ['Skills', 'skills', Database, 'skills', '/admin/skills'],
  ['Testimonials', 'testimonials', MessageSquare, 'testimonials', '/admin/testimonials'],
  ['Advertisements', 'advertisements', Sparkles, 'advertisements', '/admin/advertisements'],
] as const;

function age(value:any) {
  if (!value) return 'Recently';
  const d = new Date(value), days = Math.max(0, Math.floor((Date.now()-d.getTime())/86400000));
  if (days === 0) return 'Today';
  if (days === 1) return '1 day ago';
  if (days < 7) return `${days} days ago`;
  if (days < 14) return '1 week ago';
  return `${Math.floor(days/7)} weeks ago`;
}

export default function Dashboard() {
  const nav = useNavigate();
  const [data,setData]=useState<any>(null);
  const [addOpen,setAddOpen]=useState(false);
  const [feedback,setFeedback]=useState<any>(null);

  useEffect(()=>{api.get('/admin/dashboard').then(r=>setData(r.data)).catch(e=>setFeedback({title:'Dashboard unavailable',message:e?.response?.data?.message||'We could not load the latest workspace information.'}));},[]);
  const counts=data?.counts||{};

  return (
    <AdminPage eyebrow="WELCOME BACK" title="Dashboard" description="Manage your portfolio, track activity and keep your content up to date."
      action={<div className="dashboard-add-wrap">
        <button className="admin-action dashboard-add" onClick={()=>setAddOpen(v=>!v)}><Sparkles size={16}/> Add New Content <ChevronRight size={15}/></button>
        {addOpen && <div className="dashboard-add-menu">
          {[
            ['Project','/admin/projects'],['Experience','/admin/experience'],['Education','/admin/education'],
            ['Certification','/admin/certifications'],['Service','/admin/services'],['Skill','/admin/skills'],
            ['Achievement','/admin/achievements'],['Testimonial','/admin/testimonials'],['Advertisement','/admin/advertisements'],
          ].map(([label,path])=><button key={path} onClick={()=>nav(path)}>{label}</button>)}
        </div>}
      </div>}>
      <div className="dashboard-grid">
        {statDefs.map(([label,key,Icon,sub,path],i)=><button className={`dashboard-stat dashboard-stat--${i}`} key={key} onClick={()=>nav(path)}>
          <span className="dashboard-stat__icon"><Icon size={22}/></span>
          <span className="dashboard-stat__body"><small>{label}</small><strong>{counts[key] ?? 0}</strong><em>{key === 'education' ? 'Academic records' : key === 'advertisements' ? 'Active campaigns' : `Current ${sub}`}</em></span>
          <ChevronRight size={17} className="dashboard-stat__arrow"/>
        </button>)}
      </div>

      <div className="dashboard-content-grid">
        <div className="admin-panel dashboard-content-panel">
          <PanelTitle title="Recent content" action={<span className="panel-link panel-link--muted">Click an item to manage</span>}/>
          {data?.recent_content?.length ? <div className="dashboard-list">{data.recent_content.map((x:any)=><button className="dashboard-list-row dashboard-list-row--clickable" key={`${x.type}-${x.id}`} onClick={()=>nav(contentPath(x.type))} aria-label={`Open ${x.type_label}: ${x.title}`}>
            <span className={`content-icon content-icon--${x.type}`}><IconFor type={x.type}/></span>
            <span className="dashboard-list-main"><strong>{x.title}</strong><small>{x.type_label}</small></span>
            <span className="dashboard-list-time">{age(x.updated_at)}</span>
            <span className={`status status-${x.is_published ? 'published':'draft'}`}>{x.is_published?'Published':'Draft'}</span>
            <ChevronRight size={16}/>
          </button>)}</div> : <EmptyState icon={FolderKanban} title="No recent content yet" description="Your latest projects, experience, skills and other records will appear here."/>}
        </div>

        <div className="admin-panel dashboard-content-panel">
          <PanelTitle title="Recent messages" action={<button className="panel-link panel-link--button" onClick={()=>nav('/admin/messages')}>View all</button>}/>
          {data?.recent_messages?.length ? <div className="dashboard-list">{data.recent_messages.map((x:any)=><button className="dashboard-list-row dashboard-list-row--clickable" key={x.id} onClick={()=>nav(`/admin/messages?message=${x.id}`)} aria-label={`Open message from ${x.name || x.email || 'contact'}`}>
            <span className="message-avatar">{String(x.name||'A').slice(0,2).toUpperCase()}</span>
            <span className="dashboard-list-main"><strong>{x.name || x.subject || 'Contact message'}</strong><small>{x.message || x.subject || x.email || 'New message'}</small></span>
            <span className="dashboard-list-time">{age(x.created_at)}</span>
            <span className={`status status-${String(x.status||'new').replaceAll('_','-')}`}>{String(x.status||'new').replaceAll('_',' ')}</span>
            <ChevronRight size={16}/>
          </button>)}</div> : <EmptyState icon={MessageSquare} title="Your inbox is empty" description="New messages sent through the public portfolio will appear here."/>}
        </div>
      </div>

      <div className="dashboard-growth">
        <div className="dashboard-growth__icon"><BarChart3 size={25}/></div>
        <div><strong>Your portfolio is growing!</strong><span>Keep adding projects, skills and achievements to showcase your work.</span></div>
        <button onClick={()=>window.open('/', '_blank', 'noopener,noreferrer')}>View Public Portfolio <ArrowRight size={16}/></button>
      </div>
      {feedback && <FeedbackModal kind="error" title={feedback.title} message={feedback.message} onClose={()=>setFeedback(null)}/>}
    </AdminPage>
  );
}
function contentPath(type:string) {
  const paths: Record<string,string> = {
    project: '/admin/projects',
    experience: '/admin/experience',
    certification: '/admin/certifications',
    skill: '/admin/skills',
    service: '/admin/services',
    education: '/admin/education',
    achievement: '/admin/achievements',
    testimonial: '/admin/testimonials',
    advertisement: '/admin/advertisements',
  };
  return paths[type] || '/admin';
}

function IconFor({type}:{type:string}) {
  if(type==='project') return <FolderKanban size={18}/>;
  if(type==='experience') return <BriefcaseBusiness size={18}/>;
  if(type==='certification') return <Award size={18}/>;
  if(type==='skill') return <Database size={18}/>;
  if(type==='service') return <Wrench size={18}/>;
  return <FileText size={18}/>;
}
