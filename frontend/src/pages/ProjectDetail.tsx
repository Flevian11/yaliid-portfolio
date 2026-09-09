import { useEffect, useState } from 'react';
import { ArrowLeft, ArrowUpRight, CheckCircle2, ExternalLink } from 'lucide-react';
import { Link, useParams } from 'react-router-dom';
import SectionLabel from '../components/SectionLabel';
import { portfolioApi } from '../api';
import type { Project } from '../types';

export default function ProjectDetail() {
  const { slug } = useParams();
  const [project, setProject] = useState<Project | null>(null);
  const [error, setError] = useState(false);

  useEffect(() => {
    if (!slug) return;
    setError(false);
    setProject(null);
    portfolioApi.project(slug).then(setProject).catch(() => setError(true));
  }, [slug]);

  if (error) {
    return (
      <main className="inner-page">
        <div className="container project-error">
          <Link to="/projects" className="back-link"><ArrowLeft size={15} /> All projects</Link>
          <span className="eyebrow">PROJECT / ERROR</span>
          <h1>We could not load this project.</h1>
          <p>Check that the project is published and that the API is available.</p>
        </div>
      </main>
    );
  }

  if (!project) {
    return (
      <main className="inner-page">
        <div className="container project-loading">
          <span className="eyebrow">TECHGHOST / PROJECT</span>
          <div className="loading-skeleton" />
          <div className="loading-skeleton short" />
        </div>
      </main>
    );
  }

  const featuredMedia = project.media?.find((media) => media.is_featured) || project.media?.[0];

  return (
    <main className="project-detail-page">
      <div className="container">
        <Link to="/projects" className="back-link"><ArrowLeft size={15} /> All projects</Link>

        <div className="project-detail-heading">
          <div>
            <SectionLabel>{project.project_type || 'DIGITAL PRODUCT'}</SectionLabel>
            <h1>{project.title}</h1>
          </div>
          <span className="project-status">{project.status || 'PROJECT'}</span>
        </div>

        {project.short_description && <p className="project-lead">{project.short_description}</p>}

        {featuredMedia && (
          <div className="project-cover">
            <img src={featuredMedia.file_path} alt={featuredMedia.alt_text || project.title} />
            <span>TECHGHOST / PROJECT</span>
          </div>
        )}

        <div className="project-detail-grid">
          <article className="project-story">
            <Story title="Overview" text={project.description} />
            {project.problem && <Story title="The problem" text={project.problem} />}
            {project.solution && <Story title="The solution" text={project.solution} />}
            {project.results && <Story title="Results" text={project.results} />}

            {project.features?.length ? (
              <section className="story-section">
                <span className="eyebrow">FUNCTIONALITY</span>
                <h2>What the system does.</h2>
                <div className="feature-list">
                  {project.features.map((feature) => (
                    <div key={feature.id}>
                      <CheckCircle2 size={17} />
                      <span><strong>{feature.title}</strong>{feature.description ? ` — ${feature.description}` : ''}</span>
                    </div>
                  ))}
                </div>
              </section>
            ) : null}
          </article>

          <aside className="project-sidebar">
            <div className="sidebar-block">
              <span className="eyebrow">TECHNOLOGY</span>
              <div className="technology-list">
                {project.technologies?.map((technology) => (
                  <span key={technology.id}>{technology.name}</span>
                ))}
              </div>
            </div>

            {(project.live_url || project.github_url) && (
              <div className="sidebar-actions">
                {project.live_url && (
                  <a className="button button-dark" href={project.live_url} target="_blank" rel="noreferrer">
                    Live project <ExternalLink size={15} />
                  </a>
                )}
                {project.github_url && (
                  <a className="button button-ghost" href={project.github_url} target="_blank" rel="noreferrer">
                    Source code <ArrowUpRight size={15} />
                  </a>
                )}
              </div>
            )}

            <div className="sidebar-note">
              <span>FG / 027</span>
              <p>Built with purpose. Documented for clarity.</p>
            </div>
          </aside>
        </div>
      </div>
    </main>
  );
}

function Story({ title, text }: { title: string; text?: string }) {
  if (!text) return null;
  return (
    <section className="story-section">
      <span className="eyebrow">{title}</span>
      <h2>{title === 'Overview' ? 'What was built.' : title}</h2>
      <p>{text}</p>
    </section>
  );
}
