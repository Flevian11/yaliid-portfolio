import { useEffect, useState, type ReactNode } from 'react';
import { NavLink, useNavigate } from 'react-router-dom';
import {
  Award, Bell, BriefcaseBusiness, FileText, FolderKanban, GraduationCap,
  Inbox, KeyRound, LayoutDashboard, LogOut, Menu, MessageSquare, Search,
  Settings, Sun, UserRound, Wrench, X, Sparkles,
} from 'lucide-react';
import { api } from '../../api';

const navGroups = [
  {
    label: 'MANAGE CONTENT',
    items: [
      ['Profile', '/admin/profile', UserRound],
      ['Experience', '/admin/experience', BriefcaseBusiness],
      ['Education', '/admin/education', GraduationCap],
      ['Certifications', '/admin/certifications', Award],
      ['Recommendation Letters', '/admin/recommendation-letters', FileText],
      ['Projects', '/admin/projects', FolderKanban],
      ['Services', '/admin/services', Wrench],
      ['Skills', '/admin/skills', Settings],
      ['Achievements', '/admin/achievements', Award],
      ['Testimonials', '/admin/testimonials', MessageSquare],
      ['Advertisements', '/admin/advertisements', Sparkles],
    ],
  },
  {
    label: 'COMMUNICATION',
    items: [
      ['Service Requests', '/admin/requests', Inbox],
      ['Messages', '/admin/messages', MessageSquare],
    ],
  },
  {
    label: 'SYSTEM',
    items: [
      ['Security', '/admin/security', KeyRound],
    ],
  },
] as const;

function currentDate() {
  return new Intl.DateTimeFormat(undefined, {
    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric',
  }).format(new Date());
}

export default function AdminShell({ user, children }: { user: any; children: ReactNode }) {
  const [open, setOpen] = useState(false);
  const [logoutOpen, setLogoutOpen] = useState(false);
  const [dark, setDark] = useState(() => localStorage.getItem('yaliid-admin-theme') === 'dark');
  const [unread, setUnread] = useState(0);
  const nav = useNavigate();

  useEffect(() => {
    document.documentElement.dataset.adminTheme = dark ? 'dark' : 'light';
    localStorage.setItem('yaliid-admin-theme', dark ? 'dark' : 'light');
  }, [dark]);

  useEffect(() => {
    api.get('/admin/dashboard').then(r => setUnread(Number(r.data?.counts?.unread_messages || 0))).catch(() => undefined);
  }, []);

  const logout = async () => {
    await api.post('/auth/logout').catch(() => undefined);
    nav('/admin/login', { replace: true });
  };

  return (
    <div className="admin-shell">
      <aside className={open ? 'show' : ''}>
        <div className="admin-brand">
          <div className="admin-brand__mark">TG</div>
          <div><strong>TechGhost</strong><small>ADMIN PORTAL</small></div>
        </div>

        <nav className="admin-nav">
          <NavLink className="admin-dashboard-link" to="/admin" end onClick={() => setOpen(false)}>
            <LayoutDashboard size={16} /><span>Dashboard</span>
          </NavLink>
          {navGroups.map(group => (
            <div className="admin-nav-group" key={group.label}>
              <small>{group.label}</small>
              {group.items.map(([label, path, Icon]) => (
                <NavLink key={path} to={path} end onClick={() => setOpen(false)}>
                  <Icon size={16} /><span>{label}</span>
                  {label === 'Messages' && unread > 0 && <b className="nav-badge">{unread}</b>}
                </NavLink>
              ))}
            </div>
          ))}
        </nav>

        <div className="admin-sidebar-footer">
          <div className="admin-user">
            <div className="admin-avatar">{String(user?.name || 'A').slice(0, 2).toUpperCase()}</div>
            <div><b>{user?.name || 'Administrator'}</b><span>{user?.role || 'Administrator'}</span></div>
          </div>
          <button className="admin-logout" onClick={() => setLogoutOpen(true)}>
            <LogOut size={16} /><span>Logout</span>
          </button>
        </div>
      </aside>

      {open && <button className="admin-overlay" aria-label="Close menu" onClick={() => setOpen(false)} />}

      <div className="admin-main">
        <header className="admin-topbar">
          <div className="admin-topbar-brand">
            <button className="admin-menu" onClick={() => setOpen(!open)} aria-label="Toggle admin menu">
              {open ? <X size={19}/> : <Menu size={19}/>}
            </button>
            <div><strong>Admin Portal</strong><span>Manage your portfolio content</span></div>
          </div>
          <div className="admin-topbar-tools">
            <label className="admin-search"><Search size={17}/><input aria-label="Search" placeholder="Search..." /></label>
            <button className="topbar-icon" onClick={() => setDark(v => !v)} aria-label={dark ? 'Use light mode' : 'Use dark mode'}>
              {dark ? <Sun size={18}/> : <Sun size={18}/>}
            </button>
            <button className="topbar-icon topbar-bell" onClick={() => nav('/admin/messages')} aria-label="Messages">
              <Bell size={18}/>{unread > 0 && <b>{unread}</b>}
            </button>
            <div className="topbar-avatar">{String(user?.name || 'A').slice(0, 2).toUpperCase()}</div>
          </div>
        </header>

        <div className="admin-datebar">
          <div className="admin-datebar__copy"><span>{currentDate()}</span><small>Good to see you, {String(user?.name || 'there').split(' ')[0]}!</small></div>
        </div>

        {children}
      </div>

      {logoutOpen && (
        <div className="modal-backdrop" onClick={(event) => { if (event.target === event.currentTarget) setLogoutOpen(false); }}>
          <div className="feedback-modal feedback-modal--warning">
            <div className="feedback-icon"><LogOut /></div>
            <small className="feedback-kicker">SECURE SESSION</small>
            <h2>Leave the admin portal?</h2>
            <p>Your current authenticated session will be closed.</p>
            <div className="modal-actions">
              <button className="admin-button secondary" onClick={() => setLogoutOpen(false)}>Stay signed in</button>
              <button className="admin-button primary" onClick={logout}>Logout</button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
