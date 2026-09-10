import { ArrowUpRight, Download } from 'lucide-react';
import type { PortfolioData, Profile } from '../types';
import SectionLabel from '../components/SectionLabel';

function formatDate(value?: string) {
  if (!value) return '—';
  const date = new Date(value);
  if (Number.isNaN(date.getTime())) return value;
  return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
}

function ProfileFallback(): Profile {
  return {
    full_name: 'Flevian Ochoka',
    professional_title: 'Software Engineer',
    tagline: '',
    professional_summary: '',
    location: 'Nairobi, Kenya',
  };
}

function EmptyState({ title, text }: { title: string; text: string }) {
  return (
    <div className="empty-panel page-empty">
      <span>CONTENT / 00</span>
      <h3>{title}</h3>
      <p>{text}</p>
    </div>
  );
}

export default function CV({ data }: { data: PortfolioData }) {
  const profile = data.profile ?? ProfileFallback();
  const summary = profile.professional_summary || profile.bio || profile.tagline;

  return (
    <main className="inner-page cv-page">
      <div className="container">
        <div className="inner-hero">
          <SectionLabel>05 / CURRICULUM VITAE</SectionLabel>
          <h1>The longer<br className="cv-title-break" /> version.</h1>
          {summary && <p className="inner-intro">{summary}</p>}
        </div>

        <div className="cv-toolbar cv-toolbar--page">
          <div>
            <span className="eyebrow">DOCUMENT</span>
            <strong>{profile.full_name} / CV</strong>
            {profile.cv_updated_at && <small>Updated {formatDate(profile.cv_updated_at)}</small>}
          </div>

          {profile.cv_file ? (
            <a className="button button-dark" href={profile.cv_file} target="_blank" rel="noreferrer">
              <Download size={15} aria-hidden="true" />
              Download CV
              <ArrowUpRight size={15} aria-hidden="true" />
            </a>
          ) : (
            <span className="document-unavailable">CV not uploaded yet</span>
          )}
        </div>

        <section className="cv-section cv-section--page">
          <div className="cv-section-title">
            <span>01</span>
            <div>
              <SectionLabel>WORK HISTORY</SectionLabel>
              <h2>Experience</h2>
            </div>
          </div>
          <div className="cv-items">
            {data.experiences.length ? data.experiences.map((item) => (
              <div className="cv-item" key={item.id}>
                <div><span>{formatDate(item.start_date)} — {item.is_current ? 'Present' : formatDate(item.end_date)}</span></div>
                <div>
                  <strong>{item.position}</strong>
                  <p>{item.organization}{item.location ? ` · ${item.location}` : ''}</p>
                  {(item.description || item.summary) && <small>{item.description || item.summary}</small>}
                </div>
              </div>
            )) : (
              <EmptyState title="Experience is being prepared." text="Published experience entries will appear here." />
            )}
          </div>
        </section>

        <section className="cv-section cv-section--page">
          <div className="cv-section-title">
            <span>02</span>
            <div>
              <SectionLabel>ACADEMIC BACKGROUND</SectionLabel>
              <h2>Education</h2>
            </div>
          </div>
          <div className="cv-items">
            {data.education.length ? data.education.map((item) => (
              <div className="cv-item" key={item.id}>
                <div><span>{formatDate(item.start_date)} — {formatDate(item.end_date)}</span></div>
                <div>
                  <strong>{item.qualification}</strong>
                  <p>{item.institution}{item.field_of_study ? ` · ${item.field_of_study}` : ''}</p>
                  {item.description && <small>{item.description}</small>}
                </div>
              </div>
            )) : (
              <EmptyState title="Education is being prepared." text="Published education entries will appear here." />
            )}
          </div>
        </section>

        <section className="cv-section cv-section--page">
          <div className="cv-section-title">
            <span>03</span>
            <div>
              <SectionLabel>CREDENTIALS</SectionLabel>
              <h2>Certifications</h2>
            </div>
          </div>
          <div className="cv-items">
            {data.certifications.length ? data.certifications.map((item) => (
              <div className="cv-item" key={item.id}>
                <div><span>{formatDate(item.issue_date)}</span></div>
                <div>
                  <strong>{item.name}</strong>
                  <p>{item.issuing_organization}</p>
                  {item.credential_id && <small>Credential {item.credential_id}</small>}
                  {item.credential_url && (
                    <a href={item.credential_url} target="_blank" rel="noreferrer">
                      Verify credential <ArrowUpRight size={13} aria-hidden="true" />
                    </a>
                  )}
                </div>
              </div>
            )) : (
              <EmptyState title="Certifications are being prepared." text="Published certification entries will appear here." />
            )}
          </div>
        </section>
      </div>
    </main>
  );
}
