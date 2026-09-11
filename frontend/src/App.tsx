import { useEffect, useState } from 'react';
import { BrowserRouter, Route, Routes, useLocation } from 'react-router-dom';
import Header from './components/Header';
import Footer from './components/Footer';
import { portfolioApi } from './api';
import type { PortfolioData } from './types';
import Home from './pages/Home';
import { About, Projects, RequestService, Contact } from './pages/Pages';
import Experience from './pages/Experience';
import Services from './pages/Services';
import CV from './pages/CV';
import ProjectDetail from './pages/ProjectDetail';
import AdminApp, { AdminLogin } from './admin/AdminApp';
import './App.css';
import './admin/Admin.css';

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

function ScrollToTop() {
  const { pathname } = useLocation();

  useEffect(() => {
    window.scrollTo({ top: 0, left: 0, behavior: 'auto' });
  }, [pathname]);

  return null;
}


function SeoHead({ data }: { data: PortfolioData | null }) {
  const location = useLocation();

  useEffect(() => {
    const profile = data?.profile;
    const name = profile?.full_name || 'Flevian Ochoka';
    const professionalTitle = profile?.professional_title || 'Software Engineer';
    const summary = profile?.professional_summary || profile?.bio || profile?.tagline ||
      'Flevian Ochoka is a software engineer and digital systems builder creating practical web applications, business systems and digital products.';

    const path = location.pathname.replace(/\/+$/, '') || '/';
    const project = path.startsWith('/projects/')
      ? data?.projects.find((item) => `/projects/${item.slug}` === path)
      : undefined;

    const pageMeta: Record<string, { title: string; description: string }> = {
      '/': {
        title: `${name} — Software Engineer, TechGhost | Digital Systems & Web Development`,
        description: `${name} is a ${professionalTitle} who designs and builds practical digital systems, web applications, business software and digital products.`,
      },
      '/about': {
        title: `About ${name} — Software Engineer & Digital Systems Builder`,
        description: `Learn about ${name}, a software engineer focused on practical software systems, web development, digital products and technology solutions.`,
      },
      '/experience': {
        title: `${name} — Professional Experience | Software Engineering`,
        description: `Explore ${name}'s professional experience, engineering roles, responsibilities, achievements and software systems built across real-world projects.`,
      },
      '/projects': {
        title: `${name} — Projects | Software, Web & Digital Products`,
        description: `Explore software projects and digital products built by ${name}, including web applications, business systems, platforms, simulations and AI-powered solutions.`,
      },
      '/services': {
        title: `${name} — Software Development & Digital Services`,
        description: `Work with ${name} on custom software systems, web applications, digital products, interfaces and practical technology solutions.`,
      },
      '/cv': {
        title: `${name} — CV | Software Engineer`,
        description: `${name}'s curriculum vitae, professional experience, education, certifications, skills and software engineering background.`,
      },
      '/request-service': {
        title: `Start a Project with ${name} — Software Development`,
        description: `Request a software, web development or digital product project from ${name} and turn a real requirement into a useful system.`,
      },
      '/contact': {
        title: `Contact ${name} — TechGhost`,
        description: `Contact ${name} about software engineering, web development, digital systems, technology projects or collaboration.`,
      },
    };

    const meta = project
      ? {
          title: `${project.title} — ${name} | TechGhost`,
          description: project.short_description || project.description ||
            `View ${project.title}, a software and digital product project by ${name}.`,
        }
      : pageMeta[path] || {
          title: `${name} — ${professionalTitle} | TechGhost`,
          description: summary,
        };

    const canonicalUrl = `${window.location.origin}${path}`;

    document.title = meta.title;

    const setMeta = (nameOrProperty: string, content: string, property = false) => {
      const selector = property
        ? `meta[property="${nameOrProperty}"]`
        : `meta[name="${nameOrProperty}"]`;
      let element = document.head.querySelector<HTMLMetaElement>(selector);
      if (!element) {
        element = document.createElement('meta');
        if (property) element.setAttribute('property', nameOrProperty);
        else element.setAttribute('name', nameOrProperty);
        document.head.appendChild(element);
      }
      element.setAttribute('content', content);
    };

    const setLink = (rel: string, href: string) => {
      let element = document.head.querySelector<HTMLLinkElement>(`link[rel="${rel}"]`);
      if (!element) {
        element = document.createElement('link');
        element.setAttribute('rel', rel);
        document.head.appendChild(element);
      }
      element.setAttribute('href', href);
    };

    const isAdmin = path.startsWith('/admin');
    setMeta('description', isAdmin ? 'Private administration area.' : meta.description);
    setMeta('author', name);
    setMeta('creator', name);
    setMeta('publisher', name);
    setMeta('robots', isAdmin
      ? 'noindex,nofollow,noarchive'
      : 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1');
    setMeta('googlebot', isAdmin
      ? 'noindex,nofollow,noarchive'
      : 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1');

    if (!isAdmin) {
      setMeta(
        'keywords',
        `${name}, Flevian Ochoka software engineer, Flevian Ochoka developer, TechGhost, software engineer Nairobi, Kenya software developer, web developer, custom software development, digital systems, web applications, business software, artificial intelligence, digital product development`
      );
    }

    setMeta('og:title', meta.title, true);
    setMeta('og:description', meta.description, true);
    setMeta('og:type', project ? 'article' : 'website', true);
    setMeta('og:url', canonicalUrl, true);
    setMeta('og:site_name', 'Flevian Ochoka — TechGhost', true);
    setMeta('twitter:card', 'summary', false);
    setMeta('twitter:title', meta.title, false);
    setMeta('twitter:description', meta.description, false);
    setLink('canonical', canonicalUrl);

    const existing = document.head.querySelector<HTMLScriptElement>('script[data-seo-jsonld]');
    if (existing) existing.remove();

    if (!isAdmin) {
      const skills = (data?.skills || []).flatMap((category) =>
        category.skills.map((skill) => skill.name)
      );

      const graph: Record<string, unknown>[] = [
        {
          '@type': 'Person',
          '@id': `${window.location.origin}/#person`,
          name,
          url: `${window.location.origin}/`,
          jobTitle: professionalTitle,
          description: summary,
          address: profile?.location ? {
            '@type': 'PostalAddress',
            addressLocality: profile.location,
            addressCountry: 'KE',
          } : undefined,
          sameAs: [
            'https://github.com/Flevian11',
            'https://www.reddit.com/user/Budget_Background713/',
          ],
          knowsAbout: skills.length ? skills : [
            'Software engineering',
            'Web development',
            'Digital systems',
            'Business software',
            'Artificial intelligence',
            'Digital product development',
          ],
        },
        {
          '@type': 'WebSite',
          '@id': `${window.location.origin}/#website`,
          url: `${window.location.origin}/`,
          name: 'Flevian Ochoka — TechGhost',
          description: 'Portfolio of Flevian Ochoka — software engineer and digital systems builder.',
          publisher: { '@id': `${window.location.origin}/#person` },
          inLanguage: 'en-KE',
        },
      ];

      if (project) {
        graph.push({
          '@type': 'CreativeWork',
          '@id': `${canonicalUrl}#project`,
          name: project.title,
          url: canonicalUrl,
          description: project.description || project.short_description || '',
          creator: { '@id': `${window.location.origin}/#person` },
        });
      }

      const script = document.createElement('script');
      script.type = 'application/ld+json';
      script.dataset.seoJsonld = 'true';
      script.textContent = JSON.stringify({
        '@context': 'https://schema.org',
        '@graph': graph,
      });
      document.head.appendChild(script);
    }
  }, [data, location.pathname]);

  return null;
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
      <Route path="login" element={<AdminLogin />} />
      <Route path="*" element={<AdminApp />} />
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
      <ScrollToTop />
      <SeoHead data={data} />
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
