import { ArrowDownRight, ArrowLeft, ArrowRight, ArrowUpRight, Code2, Layers3, Quote, Sparkles, Star } from 'lucide-react';
import { Link } from 'react-router-dom';
import { useEffect, useState } from 'react';
import SectionLabel from '../components/SectionLabel';
import type { PortfolioData } from '../types';

const fallbackProfile = {
  full_name: 'Flevian Ochoka',
  professional_title: 'Software Engineer',
  tagline: 'I design and build practical digital systems that turn real problems into useful products.',
  professional_summary: 'I design and build practical digital systems that turn real problems into useful products.',
  location: 'Nairobi, Kenya',
};

export default function Home({ data }: { data: PortfolioData }) {
  const profile = data.profile ?? fallbackProfile;
  const projects = Array.isArray(data.projects) ? data.projects : [];
  const advertisements = Array.isArray(data.advertisements) ? data.advertisements : [];
  const testimonials = Array.isArray(data.testimonials) ? data.testimonials : [];
  const [testimonialIndex, setTestimonialIndex] = useState(0);

  useEffect(() => {
    if (testimonials.length <= 1) return;
    const timer = window.setInterval(() => {
      setTestimonialIndex((current) => (current + 1) % testimonials.length);
    }, 6000);
    return () => window.clearInterval(timer);
  }, [testimonials.length]);

  useEffect(() => {
    if (testimonialIndex >= testimonials.length && testimonials.length) {
      setTestimonialIndex(0);
    }
  }, [testimonialIndex, testimonials.length]);

  const testimonial = testimonials[testimonialIndex];

  return (
    <>
      <section className="home-hero">
        <div className="home-hero__backdrop" aria-hidden="true">
          <div className="home-hero__image" />
          <div className="home-hero__veil" />
          <div className="home-hero__glow home-hero__glow--one" />
          <div className="home-hero__glow home-hero__glow--two" />
          <div className="home-hero__onevoice">27</div>
          <div className="home-hero__line home-hero__line--one" />
          <div className="home-hero__line home-hero__line--two" />
        </div>

        <div className="container home-hero__content">
          <div className="home-hero__copy">
            <div className="hero-kicker"><span /> SOFTWARE ENGINEER / BUILDER</div>
            <h1 className="home-hero__title">
              <span>{profile.full_name || fallbackProfile.full_name}</span>
              <em>TechGhost</em>
            </h1>

            <div className="home-hero__meta">
              <strong>{profile.professional_title || fallbackProfile.professional_title}</strong>
              <span>{profile.location || fallbackProfile.location}</span>
            </div>

            <p className="home-hero__lead">
              {profile.tagline || profile.professional_summary || fallbackProfile.tagline}
            </p>

            <div className="home-hero__actions">
              <Link className="button button--dark" to="/request-service">
                Start a project <ArrowUpRight size={17} />
              </Link>
              <Link className="button button--light" to="/projects">
                Explore selected work <ArrowDownRight size={17} />
              </Link>
            </div>
          </div>

          <div className="home-hero__visual" aria-hidden="true">
            <div className="hero-index">FG / 027</div>
            <div className="hero-panel hero-panel--main">
              <div className="hero-panel__top"><span>TECHGHOST</span><span>01</span></div>
              <div className="hero-panel__symbol">FG</div>
              <div className="hero-panel__statement">Useful software<br /><b>over empty complexity.</b></div>
              <div className="hero-panel__footer"><span>BUILD / SHIP / IMPROVE</span><span>027</span></div>
            </div>
            <div className="hero-panel hero-panel--note">
              <span>02 / PRINCIPLE</span>
              <strong>Ideas become clearer when they become systems.</strong>
            </div>
            <div className="hero-vertical">FLEVIAN OCHOKA</div>
          </div>
        </div>

        <div className="container hero-footerline">
          <span>FLEVIAN OCHOKA</span>
          <span>SOFTWARE · SYSTEMS · DIGITAL PRODUCTS</span>
          <span>SCROLL TO EXPLORE ↓</span>
        </div>
      </section>

      <section className="home-intro section container">
        <div className="section-index">02 / APPROACH</div>
        <div className="home-intro__content">
          <div>
            <SectionLabel>THE APPROACH</SectionLabel>
            <h2>Build with purpose.<br /><em>Not just presence.</em></h2>
          </div>
          <p>Good software starts before the code. I work from the actual requirement, reduce unnecessary complexity, and build systems that can keep working as the organisation grows.</p>
        </div>
      </section>

      <section className="home-capabilities">
        <div className="home-capabilities__watermark" aria-hidden="true">ONEVOICE27</div>
        <div className="home-capabilities__grain" aria-hidden="true" />
        <div className="container">
          <div className="home-section-heading home-section-heading--dark">
            <div>
              <SectionLabel>03 / CAPABILITIES</SectionLabel>
              <h2>Build the right<br /><em>thing first.</em></h2>
            </div>
            <div className="home-section-heading__side">
              <span>TECHGHOST</span>
              <p>A focused mix of engineering, product thinking and digital design. The work is shaped around the requirement rather than a fixed package.</p>
            </div>
          </div>

          <div className="capability-grid">
            {[
              { number: '01', icon: Layers3, title: 'Systems & software', text: 'Business platforms, management systems, POS solutions and custom applications built around operational needs.' },
              { number: '02', icon: Code2, title: 'Web development', text: 'Responsive websites and web applications with clean architecture and maintainable implementation.' },
              { number: '03', icon: Sparkles, title: 'Design & digital', text: 'Interfaces and digital experiences that make information easier to understand and use.' },
            ].map(({ number, icon: Icon, title, text }) => (
              <article className="capability-card" key={title}>
                <div className="capability-card__top"><span>{number}</span><Icon size={23} strokeWidth={1.7} /></div>
                <div><h3>{title}</h3><p>{text}</p></div>
                <span className="capability-card__rule" />
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="home-work section container">
        <div className="home-section-heading">
          <div>
            <SectionLabel>04 / SELECTED WORK</SectionLabel>
            <h2>Systems that<br /><em>do the work.</em></h2>
          </div>
          <Link className="text-link" to="/projects">View all projects <ArrowUpRight size={16} /></Link>
        </div>

        {projects.length ? (
          <>
          <div className="project-grid project-grid--home">
            {projects.slice(0, 3).map((project, index) => (
              <Link className="project-card" to={`/projects/${project.slug}`} key={project.id}>
                <div className="project-card__head">
                  <span className="project-card__number">0{index + 1}</span>
                  <span className="project-card__type">{project.project_type || 'PROJECT'}</span>
                </div>
                <div className="project-card__body">
                  <span className="project-card__eyebrow">SELECTED WORK / {String(index + 1).padStart(2, '0')}</span>
                  <h3>{project.title}</h3>
                  <p>{project.short_description || project.description || 'A practical digital system built around a real requirement.'}</p>
                </div>
                <div className="project-card__footer">
                  <span className="project-card__link">Explore project <ArrowUpRight size={15} /></span>
                  <span className="project-card__mark" aria-hidden="true">027</span>
                </div>
              </Link>
            ))}
          </div>
          {projects.length > 3 && (
            <Link className="home-project-more" to="/projects">+{projects.length - 3} more <ArrowUpRight size={14} /></Link>
          )}
          </>
        ) : (
          <div className="home-empty"><span>PROJECTS / 00</span><strong>Selected work is being prepared.</strong><p>Published projects will appear here.</p></div>
        )}
      </section>

      {advertisements.length > 0 && (
        <section className="container home-ad-wrap">
          {advertisements.map((advertisement) => (
            <a
              className="home-ad"
              href={advertisement.destination_url || undefined}
              target={advertisement.destination_url ? '_blank' : undefined}
              rel={advertisement.destination_url ? 'noreferrer' : undefined}
              key={advertisement.id}
            >
              {advertisement.image_path && <img src={advertisement.image_path} alt={advertisement.title} loading="lazy" />}
              <div><SectionLabel>FEATURED</SectionLabel><h3>{advertisement.title}</h3><p>{advertisement.description}</p></div>
              {advertisement.destination_url && <ArrowUpRight />}
            </a>
          ))}
        </section>
      )}

      {testimonials.length > 0 && testimonial && (
        <section className="home-testimonials">
          <div className="container">
            <div className="home-section-heading">
              <div>
                <SectionLabel>05 / TESTIMONIALS</SectionLabel>
                <h2>Words from<br /><em>the people I work with.</em></h2>
              </div>
              {testimonials.length > 1 && (
                <div className="home-testimonials__controls">
                  <button type="button" aria-label="Previous testimonial" onClick={() => setTestimonialIndex((testimonialIndex - 1 + testimonials.length) % testimonials.length)}><ArrowLeft size={16} /></button>
                  <span>{String(testimonialIndex + 1).padStart(2, '0')} / {String(testimonials.length).padStart(2, '0')}</span>
                  <button type="button" aria-label="Next testimonial" onClick={() => setTestimonialIndex((testimonialIndex + 1) % testimonials.length)}><ArrowRight size={16} /></button>
                </div>
              )}
            </div>

            <article className="home-testimonial">
              <div className="home-testimonial__quote"><Quote size={28} /></div>
              <div className="home-testimonial__content">
                {testimonial.rating && (
                  <div className="home-testimonial__rating" aria-label={`${testimonial.rating} out of 5 stars`}>
                    {Array.from({ length: 5 }).map((_, index) => <Star key={index} size={15} fill={index < testimonial.rating! ? 'currentColor' : 'none'} />)}
                  </div>
                )}
                <blockquote>“{testimonial.content}”</blockquote>
                <div className="home-testimonial__person">
                  {testimonial.photo ? <img src={testimonial.photo} alt={testimonial.name} /> : <span>{testimonial.name.slice(0, 1).toUpperCase()}</span>}
                  <div><strong>{testimonial.name}</strong><small>{[testimonial.position, testimonial.organization].filter(Boolean).join(' · ')}</small></div>
                </div>
              </div>
            </article>

            {testimonials.length > 1 && (
              <div className="home-testimonials__dots" aria-label="Testimonial navigation">
                {testimonials.map((item, index) => (
                  <button key={item.id} type="button" className={index === testimonialIndex ? 'active' : ''} aria-label={`Show testimonial ${index + 1}`} onClick={() => setTestimonialIndex(index)} />
                ))}
              </div>
            )}
          </div>
        </section>
      )}

      <section className="home-closing">
        <div className="home-closing__watermark" aria-hidden="true">27</div>
        <div className="container home-closing__inner">
          <SectionLabel>{testimonials.length > 0 ? '06' : '05'} / LET'S BUILD</SectionLabel>
          <h2>Have a real problem?<br /><em>Let's build the right system.</em></h2>
          <div className="home-closing__row">
            <p>Tell me what needs to work better. We can turn the requirement into a clear, useful digital product.</p>
            <Link className="button button--purple" to="/request-service">Start a conversation <ArrowUpRight size={17} /></Link>
          </div>
          <div className="home-closing__brand"><span>ONEVOICE27</span><span>ALL THINGS NEW</span></div>
        </div>
      </section>
    </>
  );
}
