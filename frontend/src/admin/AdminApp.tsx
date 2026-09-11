import { useEffect, useState } from 'react';
import { Route, Routes, useNavigate } from 'react-router-dom';
import { api } from '../api';
import AdminShell from './components/AdminShell';
import Dashboard from './pages/Dashboard';
import ResourcePage from './pages/ResourcePage';
import { resourceConfigs } from './resourceConfig';
import InboxPages from './pages/InboxPages';
import SecurityPage from './pages/SecurityPage';
import LoginPage from './pages/LoginPage';
import './Admin.css';

export default function AdminApp() {
  const [me, setMe] = useState<any>(null);
  const [checking, setChecking] = useState(true);
  const nav = useNavigate();

  useEffect(() => {
    let active = true;
    api.get('/auth/me')
      .then((response) => {
        if (active) setMe(response.data);
      })
      .catch(() => {
        if (active) nav('/admin/login', { replace: true });
      })
      .finally(() => {
        if (active) setChecking(false);
      });
    return () => { active = false; };
  }, [nav]);

  if (checking) {
    return (
      <div className="admin-loading">
        <div className="admin-loading__mark">TG</div>
        <span>Authenticating workspace…</span>
      </div>
    );
  }

  if (!me) return null;

  return (
    <AdminShell user={me}>
      <Routes>
        <Route path="/" element={<Dashboard />} />
        {resourceConfigs.map((config) => (
          <Route
            key={config.key}
            path={`/${config.key}`}
            element={<ResourcePage config={config} />}
          />
        ))}
        <Route path="/requests" element={<InboxPages mode="requests" />} />
        <Route path="/messages" element={<InboxPages mode="messages" />} />
        <Route path="/security" element={<SecurityPage />} />
      </Routes>
    </AdminShell>
  );
}

export { LoginPage as AdminLogin };
