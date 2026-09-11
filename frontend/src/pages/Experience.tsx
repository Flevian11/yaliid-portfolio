import { ArrowUpRight, CheckCircle2, Download } from 'lucide-react';
import type { Experience as ExperienceItem, PortfolioData } from '../types';
import SectionLabel from '../components/SectionLabel';

function formatDate(value?: string) {
  if (!value) return '—';
  const date = new Date(value);
  if (Number.isNaN(date.getTime())) return value;
  return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
}

function ExperienceRow({ item, index }: { item: ExperienceItem; index: number }) {
  const end = item.is_current ? 'Present' : formatDate(item.end_date);
  const period = `${formatDate(item.start_date)} — ${end}`;
  const description = item.description || item.summary;

  return (
    <article className="experience-card experience-card--page">
      <div className="experience-index">{String(index + 1).padStart(2, '0')}</div>

      <div className="experience-content">
        <div className="experience-meta">
          <span>{period}</span>
          {item.location && <span>{item.location}</span>}
        </div>

        <div className="experience-title-row">
          <h2>{item.position}</h2>
          {item.is_current && <span className="experience-current">CURRENT</span>}
        </div>

        <div className="experience-company">
          <strong>{item.organization}</strong>
          {item.employment_type && <span className="role-type">{item.employment_type}</span>}
        </div>

        {description && <p>{description}</p>}

        {item.achievements?.length ? (
          <ul className="achievement-list">
            {item.achievements.map((achievement) => (
              <li key={achievement.id}>
                <CheckCircle2 size={16} aria-hidden="true" />
                <span>
                  <strong>{achievement.title}</strong>
                  {achievement.description ? ` — ${achievement.description}` : ''}
                </span>
              </li>
            ))}
          </ul>
        ) : null}

        {item.recommendation_letters?.length ? (
          <div className="document-links">
            {item.recommendation_letters.map((letter) => (
              <a href={letter.file_path} target="_blank" rel="noreferrer" key={letter.id}>
                <Download size={15} aria-hidden="true" />
                Download {letter.title || 'recommendation letter'}
                <ArrowUpRight size={14} aria-hidden="true" />
              </a>
            ))}
          </div>
        ) : null}
      </div>
    </article>
  );
}

export default function Experience({ data }: { data: PortfolioData }) {
  return (
    <main className="inner-page experience-page">
      <div className="container">
        <div className="inner-hero">
          <SectionLabel>02 / EXPERIENCE</SectionLabel>
          <h1>Where the work<br className="experience-title-break" /> has happened.</h1>
          <p className="inner-intro">
            Roles, responsibilities and evidence of the systems and products built along the way.
          </p>
        </div>

        <section className="experience-list experience-list--page" aria-label="Professional experience">
          {data.experiences.length ? (
            data.experiences.map((item, index) => (
              <ExperienceRow item={item} index={index} key={item.id} />
            ))
          ) : (
            <div className="empty-panel page-empty">
              <span>CONTENT / 00</span>
              <h3>Experience is being prepared.</h3>
              <p>Published experience entries will appear here.</p>
            </div>
          )}
        </section>
      </div>
    </main>
  );
}
