import { ArrowUpRight, Menu, X } from 'lucide-react';
import { useState } from 'react';
import { Link, NavLink } from 'react-router-dom';

const links = [
  { label: 'Home', to: '/' },
  { label: 'About', to: '/about' },
  { label: 'Experience', to: '/experience' },
  { label: 'Projects', to: '/projects' },
  { label: 'Services', to: '/services' },
  { label: 'CV', to: '/cv' },
  { label: 'Contact', to: '/contact' },
];

export default function Header() {
  const [open, setOpen] = useState(false);

  return (
    <header className="site-header">
      <div className="container site-header__inner">
        <Link className="brand" to="/" onClick={() => setOpen(false)}>
          <span className="brand__mark">FG</span>
          <span className="brand__text">
            <strong>Flevian Ochoka</strong>
            <small>TECHGHOST</small>
          </span>
        </Link>

        <nav className={`site-nav ${open ? 'site-nav--open' : ''}`}>
          {links.map((link) => (
            <NavLink
              key={link.to}
              to={link.to}
              end={link.to === '/'}
              onClick={() => setOpen(false)}
              className={({ isActive }) =>
                isActive ? 'site-nav__link is-active' : 'site-nav__link'
              }
            >
              {link.label}
            </NavLink>
          ))}
        </nav>

        <Link
          className="header-cta"
          to="/request-service"
          onClick={() => setOpen(false)}
        >
          Start a project <ArrowUpRight size={15} />
        </Link>

        <button
          className="header-menu"
          type="button"
          aria-label={open ? 'Close navigation' : 'Open navigation'}
          aria-expanded={open}
          onClick={() => setOpen((value) => !value)}
        >
          {open ? <X size={21} /> : <Menu size={21} />}
        </button>
      </div>
    </header>
  );
}
