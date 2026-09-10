import { ArrowUpRight } from 'lucide-react';
import { Link } from 'react-router-dom';
import type { PortfolioData } from '../types';
import SectionLabel from '../components/SectionLabel';

export default function Services({ data }: { data: PortfolioData }) {
  return (
    <main className="inner-page services-page">
      <div className="container">
        <div className="inner-hero">
          <SectionLabel>04 / SERVICES</SectionLabel>
          <h1>What I can<br className="services-title-break" /> build with you.</h1>
          <p className="inner-intro">
            Practical digital solutions from discovery through implementation, refinement and support.
          </p>
        </div>

        <section className="service-directory service-directory--page" aria-label="Services">
          {data.services.length ? (
            data.services.map((service, index) => (
              <article className="service-detail-card" key={service.id}>
                <div className="service-detail-card__number">
                  {String(index + 1).padStart(2, '0')}
                </div>

                <div className="service-detail-card__content">
                  <div className="service-detail-card__meta">
                    <span>SERVICE</span>
                    {service.slug && <span>{service.slug.replace(/-/g, ' ')}</span>}
                  </div>
                  <h2>{service.name}</h2>
                  <p>{service.description || service.short_description || 'Digital solution design and implementation tailored to the required workflow.'}</p>
                </div>

                <Link className="service-detail-card__action" to="/request-service">
                  Discuss this <ArrowUpRight size={15} aria-hidden="true" />
                </Link>
              </article>
            ))
          ) : (
            <div className="empty-panel page-empty">
              <span>CONTENT / 00</span>
              <h3>Services are being prepared.</h3>
              <p>Published services will appear here.</p>
            </div>
          )}
        </section>
      </div>
    </main>
  );
}
