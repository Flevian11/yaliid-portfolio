import { useEffect, useState } from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Header from './components/Header';
import Footer from './components/Footer';
import { portfolioApi } from './api';
import type { PortfolioData } from './types';
import Home from './pages/Home';
import { About, Experience, Projects, Services, CV, RequestService, Contact } from './pages/Pages';
import ProjectDetail from './pages/ProjectDetail';
import AdminApp, { AdminLogin } from './admin/AdminApp';
import './App.css';
import './admin/Admin.css';

const emptyPortfolio: PortfolioData = {
  profile: null,
  experiences: [],
  education: [],
  certifications: [],
  skills: [],
  projects: [],
  services: [],
  advertisements: [],
  testimonials: [],
};

function normalizePortfolio(payload: Partial<PortfolioData> | null | undefined): PortfolioData {
  return {
    profile: payload?.profile ?? null,
    experiences: Array.isArray(payload?.experiences) ? payload.experiences : [],
    education: Array.isArray(payload?.education) ? payload.education : [],
    certifications: Array.isArray(payload?.certifications) ? payload.certifications : [],
    skills: Array.isArray(payload?.skills) ? payload.skills : [],
    projects: Array.isArray(payload?.projects) ? payload.projects : [],
    services: Array.isArray(payload?.services) ? payload.services : [],
    advertisements: Array.isArray(payload?.advertisements) ? payload.advertisements : [],
    testimonials: Array.isArray(payload?.testimonials) ? payload.testimonials : [],
  };
}

function PublicLayout({ data }: { data: PortfolioData }) {
  return (
    <div className="site-shell">
      <Header />
      <main className="site-main">
        <Routes>
          <Route path="/" element={<Home data={data} />} />
          <Route path="/about" element={<About data={data} />} />
          <Route path="/experience" element={<Experience data={data} />} />
          <Route path="/projects" element={<Projects data={data} />} />
          <Route path="/projects/:slug" element={<ProjectDetail />} />
          <Route path="/services" element={<Services data={data} />} />
          <Route path="/cv" element={<CV data={data} />} />
          <Route path="/request-service" element={<RequestService services={data.services} />} />
          <Route path="/contact" element={<Contact />} />
          <Route path="*" element={<NotFound />} />
        </Routes>
      </main>
      <Footer />
    </div>
  );
}

function NotFound() {
  return (
    <main className="status-page">
      <div className="status-page__inner">
        <span className="eyebrow">TECHGHOST / 404</span>
        <h1>That page does not exist.</h1>
        <p>Use the navigation to return to the portfolio.</p>
      </div>
    </main>
  );
}

function AdminRoutes() {
  return (
    <Routes>
      <Route path="/admin/login" element={<AdminLogin />} />
      <Route path="/admin/*" element={<AdminApp />} />
    </Routes>
  );
}

export default function App() {
  const [data, setData] = useState<PortfolioData | null>(null);
  const [error, setError] = useState(false);

  useEffect(() => {
    let mounted = true;
    portfolioApi.get()
      .then((payload) => {
        if (!mounted) return;
        setData(normalizePortfolio(payload));
        setError(false);
      })
      .catch(() => {
        if (mounted) setError(true);
      });
    return () => { mounted = false; };
  }, []);

  return (
    <BrowserRouter>
      <Routes>
        <Route path="/admin/*" element={<AdminRoutes />} />
        <Route
          path="*"
          element={
            error ? (
              <div className="site-shell">
                <Header />
                <main className="status-page">
                  <div className="status-page__inner">
                    <span className="eyebrow">TECHGHOST / SYSTEM STATUS</span>
                    <h1>Portfolio API is unavailable.</h1>
                    <p>The frontend is running, but the Laravel API could not be reached. Check the backend and reload.</p>
                    <button className="button button--dark" onClick={() => window.location.reload()}>
                      Retry connection <span>↗</span>
                    </button>
                  </div>
                </main>
                <Footer />
              </div>
            ) : data ? (
              <PublicLayout data={data} />
            ) : (
              <LoadingScreen />
            )
          }
        />
      </Routes>
    </BrowserRouter>
  );
}

function LoadingScreen() {
  return (
    <div className="app-loading" role="status" aria-label="Loading TechGhost portfolio">
      <div className="loader-orbit" aria-hidden="true">
        <span>FG</span>
      </div>
      <div className="loader-copy">
        <strong>Flevian Ochoka</strong>
        <span>TECHGHOST</span>
        <small>BUILD / SHIP / IMPROVE</small>
      </div>
      <div className="loader-progress" aria-hidden="true"><i /></div>
    </div>
  );
}
