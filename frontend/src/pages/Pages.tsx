import { useState } from 'react';
import type { FormEvent, ReactNode } from 'react';
import { ArrowUpRight, CheckCircle2, FileText, Send } from 'lucide-react';
import { Link } from 'react-router-dom';
import SectionLabel from '../components/SectionLabel';
import { portfolioApi } from '../api';
import type { PortfolioData, Service } from '../types';

function Page({
  label,
  title,
  intro,
  children,
  dark = false,
}: {
  label: string;
  title: string;
  intro?: string;
  children: ReactNode;
  dark?: boolean;
}) {
  return (
    <main className={`inner-page ${dark ? 'inner-page-dark' : ''}`}>
      <div className="container">
        <div className="inner-hero">
          <SectionLabel>{label}</SectionLabel>
          <h1>{title}</h1>
          {intro && <p className="inner-intro">{intro}</p>}
        </div>
        {children}
      </div>
    </main>
  );
}

export function About({ data }: { data: PortfolioData }) {
  const profile = data.profile ?? {
    full_name: 'Flevian Ochoka',
    professional_title: 'Software Engineer',
    tagline: '',
    professional_summary: '',
    location: 'Nairobi, Kenya',
  };
  const summary = profile.bio || profile.professional_summary || profile.tagline || '';

  return (
    <Page
      label="01 / ABOUT FLEVIAN"
      title="A builder who likes useful software."
      intro={summary}
    >
      <div className="about-layout">
        <div className="about-copy">
          <p className="lead-copy">
            I am <strong>Flevian Ochoka</strong>, working under the name <strong>TechGhost</strong>.
            My focus is building practical digital products, business systems and
            web experiences that solve clearly defined problems.
          </p>
          {profile.professional_summary && <p>{profile.professional_summary}</p>}
          {profile.bio && <p>{profile.bio}</p>}
        </div>

        <aside className="fact-card">
          <span className="fact-card-mark">FG</span>
          <div>
            <small>LOCATION</small>
            <strong>{profile.location || 'Nairobi, Kenya'}</strong>
          </div>
          {profile.availability_text && (
            <div>
              <small>AVAILABILITY</small>
              <strong>{profile.availability_text}</strong>
            </div>
          )}
          {profile.email && (
            <a href={`mailto:${profile.email}`}>
              {profile.email} <ArrowUpRight size={14} />
            </a>
          )}
        </aside>
      </div>

      <section className="page-block">
        <div className="block-heading">
          <SectionLabel>FOCUS</SectionLabel>
          <h2>Engineering with product sense.</h2>
        </div>
        <div className="focus-grid">
          <FocusCard title="Understand the problem" text="Start with the workflow, users and outcome before choosing the implementation." />
          <FocusCard title="Build the foundation" text="Use architecture that can grow without making the first version unnecessarily complicated." />
          <FocusCard title="Make it usable" text="Pair reliable engineering with interfaces that make the next action obvious." />
        </div>
      </section>
    </Page>
  );
}

export function Experience({ data }: { data: PortfolioData }) {
  return (
    <Page
      label="02 / EXPERIENCE"
      title="Where the work has happened."
      intro="Roles, responsibilities and evidence of the systems and products built along the way."
    >
      <div className="experience-list">
        {data.experiences.length ? data.experiences.map((item, index) => (
          <article className="experience-card" key={item.id}>
            <div className="experience-index">0{index + 1}</div>
            <div className="experience-content">
              <div className="experience-meta">
                <span>{formatDate(item.start_date)} — {item.is_current ? 'Present' : formatDate(item.end_date)}</span>
                {item.location && <span>{item.location}</span>}
              </div>
              <h2>{item.position}</h2>
              <strong>{item.organization}</strong>
              {item.employment_type && <small className="role-type">{item.employment_type}</small>}
              {(item.description || item.summary) && <p>{item.description || item.summary}</p>}
              {item.achievements?.length ? (
                <ul className="achievement-list">
                  {item.achievements.map((achievement) => (
                    <li key={achievement.id}>
                      <CheckCircle2 size={16} />
                      <span><strong>{achievement.title}</strong>{achievement.description ? ` — ${achievement.description}` : ''}</span>
                    </li>
                  ))}
                </ul>
              ) : null}
              {item.recommendation_letters?.length ? (
                <div className="document-links">
                  {item.recommendation_letters.map((letter) => (
                    <a href={letter.file_path} target="_blank" rel="noreferrer" key={letter.id}>
                      <FileText size={15} /> {letter.title || 'Recommendation letter'} <ArrowUpRight size={14} />
                    </a>
                  ))}
                </div>
              ) : null}
            </div>
          </article>
        )) : (
          <EmptyState title="Experience is being prepared." text="Published experience entries will appear here." />
        )}
      </div>
    </Page>
  );
}

export function Projects({ data }: { data: PortfolioData }) {
  return (
    <Page
      label="03 / PROJECTS"
      title="Selected work."
      intro="Systems, products and digital experiences. Open a project to see the problem, approach, result and technology behind it."
    >
      {data.projects.length ? (
        <div className="project-directory">
          {data.projects.map((project, index) => (
            <Link to={`/projects/${project.slug}`} className="directory-project" key={project.id}>
              <span className="directory-number">0{index + 1}</span>
              <div>
                <small>{project.project_type || 'DIGITAL PRODUCT'}</small>
                <h2>{project.title}</h2>
                <p>{project.short_description || project.description}</p>
              </div>
              <ArrowUpRight size={23} />
            </Link>
          ))}
        </div>
      ) : (
        <EmptyState title="No projects published yet." text="Projects added and published from the admin dashboard will appear here." />
      )}
    </Page>
  );
}

export function Services({ data }: { data: PortfolioData }) {
  return (
    <Page
      label="04 / SERVICES"
      title="What I can build with you."
      intro="Practical digital solutions from discovery through implementation, refinement and support."
    >
      <div className="service-directory">
        {data.services.length ? data.services.map((service, index) => (
          <article className="service-detail-card" key={service.id}>
            <span>0{index + 1}</span>
            <div>
              <h2>{service.name}</h2>
              <p>{service.description || service.short_description}</p>
            </div>
            <Link to="/request-service">Discuss this <ArrowUpRight size={15} /></Link>
          </article>
        )) : (
          <EmptyState title="Services are being prepared." text="Published services will appear here." />
        )}
      </div>
    </Page>
  );
}

export function CV({ data }: { data: PortfolioData }) {
  const profile = data.profile ?? {
    full_name: 'Flevian Ochoka',
    professional_title: 'Software Engineer',
    tagline: '',
    professional_summary: '',
    location: 'Nairobi, Kenya',
  };
  return (
    <Page
      label="05 / CURRICULUM VITAE"
      title="The longer version."
      intro={profile.professional_summary || profile.tagline}
    >
      <div className="cv-toolbar">
        <div>
          <span className="eyebrow">DOCUMENT</span>
          <strong>{profile.full_name} / CV</strong>
        </div>
        {profile.cv_file ? (
          <a className="button button-dark" href={profile.cv_file} target="_blank" rel="noreferrer">
            Download CV <ArrowUpRight size={16} />
          </a>
        ) : (
          <span className="document-unavailable">CV not uploaded yet</span>
        )}
      </div>

      <section className="cv-section">
        <div className="cv-section-title"><span>01</span><h2>Experience</h2></div>
        <div className="cv-items">
          {data.experiences.length ? data.experiences.map((item) => (
            <div className="cv-item" key={item.id}>
              <div><span>{formatDate(item.start_date)} — {item.is_current ? 'Present' : formatDate(item.end_date)}</span></div>
              <div><strong>{item.position}</strong><p>{item.organization}</p></div>
            </div>
          )) : <EmptyState title="Experience is being prepared." text="Published experience entries will appear here." />}
        </div>
      </section>

      <section className="cv-section">
        <div className="cv-section-title"><span>02</span><h2>Education</h2></div>
        <div className="cv-items">
          {data.education.length ? data.education.map((item) => (
            <div className="cv-item" key={item.id}>
              <div><span>{formatDate(item.start_date)} — {formatDate(item.end_date)}</span></div>
              <div><strong>{item.qualification}</strong><p>{item.institution}{item.field_of_study ? ` · ${item.field_of_study}` : ''}</p></div>
            </div>
          )) : <EmptyState title="Education is being prepared." text="Published education entries will appear here." />}
        </div>
      </section>

      <section className="cv-section">
        <div className="cv-section-title"><span>03</span><h2>Certifications</h2></div>
        <div className="cv-items">
          {data.certifications.length ? data.certifications.map((item) => (
            <div className="cv-item" key={item.id}>
              <div><span>{formatDate(item.issue_date)}</span></div>
              <div>
                <strong>{item.name}</strong>
                <p>{item.issuing_organization}</p>
                {item.credential_url && <a href={item.credential_url} target="_blank" rel="noreferrer">Verify credential <ArrowUpRight size={13} /></a>}
              </div>
            </div>
          )) : <EmptyState title="Certifications are being prepared." text="Published certification entries will appear here." />}
        </div>
      </section>
    </Page>
  );
}

export function RequestService({ services }: { services: Service[] }) {
  return <SubmissionPage service={services} />;
}

export function Contact() {
  return <SubmissionPage />;
}

function SubmissionPage({ service }: { service?: Service[] }) {
  const isService = Boolean(service);
  const [status, setStatus] = useState<'idle' | 'sending' | 'success' | 'error'>('idle');

  async function submit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();
    setStatus('sending');
    const form = new FormData(event.currentTarget);
    const payload = Object.fromEntries(form.entries());

    try {
      if (isService) await portfolioApi.request(payload);
      else await portfolioApi.message(payload);
      event.currentTarget.reset();
      setStatus('success');
    } catch (error) {
      console.error('Submission failed:', error);
      setStatus('error');
    }
  }

  return (
    <Page
      label={isService ? '06 / START A PROJECT' : '06 / CONTACT'}
      title={isService ? 'Tell me what needs building.' : 'Start a conversation.'}
      intro={isService
        ? 'Give me enough context to understand the problem, the desired outcome and what you already have.'
        : 'For collaborations, questions or anything that does not fit a service request.'}
    >
      <div className="submission-layout">
        <div className="submission-note">
          <span className="note-mark">FG</span>
          <h2>Good work starts with a clear brief.</h2>
          <p>
            You do not need a perfect technical specification. Describe the
            situation in plain language and I will take it from there.
          </p>
          <div className="note-lines">
            <span>What are you trying to achieve?</span>
            <span>What is not working today?</span>
            <span>What would success look like?</span>
          </div>
        </div>

        <form className="submission-form" onSubmit={submit}>
          {isService && (
            <Field label="Service">
              <select name="service_id" required>
                <option value="">Select a service</option>
                {service?.map((item) => <option value={item.id} key={item.id}>{item.name}</option>)}
              </select>
            </Field>
          )}
          <Field label="Name"><input name="name" required autoComplete="name" /></Field>
          <Field label="Email"><input name="email" type="email" required autoComplete="email" /></Field>
          <Field label="Phone"><input name="phone" autoComplete="tel" /></Field>
          {isService && <Field label="Budget"><input name="budget" type="number" min="0" inputMode="decimal" /></Field>}
          {!isService && <Field label="Subject"><input name="subject" required /></Field>}
          <Field label={isService ? 'Project brief' : 'Message'}>
            <textarea name={isService ? 'description' : 'message'} rows={7} required />
          </Field>

          {status === 'success' && (
            <div className="form-status success"><CheckCircle2 size={18} /> Your submission has been received.</div>
          )}
          {status === 'error' && (
            <div className="form-status error">Something went wrong. Please try again.</div>
          )}

          <button className="button button-dark submit-button" disabled={status === 'sending'}>
            {status === 'sending' ? 'Sending…' : isService ? 'Submit service request' : 'Send message'}
            {status !== 'sending' && <Send size={16} />}
          </button>
        </form>
      </div>
    </Page>
  );
}

function Field({ label, children }: { label: string; children: ReactNode }) {
  return <label className="form-field"><span>{label}</span>{children}</label>;
}

function FocusCard({ title, text }: { title: string; text: string }) {
  return <article className="focus-card"><span>+</span><h3>{title}</h3><p>{text}</p></article>;
}

function EmptyState({ title, text }: { title: string; text: string }) {
  return <div className="empty-panel page-empty"><span>CONTENT / 00</span><h3>{title}</h3><p>{text}</p></div>;
}

function formatDate(value?: string) {
  if (!value) return '—';
  const date = new Date(value);
  if (Number.isNaN(date.getTime())) return value;
  return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
}
