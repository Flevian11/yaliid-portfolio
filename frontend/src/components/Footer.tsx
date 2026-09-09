import { ArrowUpRight } from 'lucide-react';
import { Link } from 'react-router-dom';

export default function Footer() {
  return (
    <footer className="site-footer">
      <div className="container">
        <div className="footer-main">
          <div>
            <span className="footer-mark">FG</span>
            <h2>Flevian Ochoka</h2>
            <p>Software engineering · systems · digital products</p>
          </div>

          <div className="footer-identity">
            <span>WORKING AS</span>
            <strong>TECHGHOST</strong>
            <small>BUILD / SHIP / IMPROVE</small>
          </div>

          <div className="footer-links">
            <Link to="/projects">Projects <ArrowUpRight size={14} /></Link>
            <Link to="/services">Services <ArrowUpRight size={14} /></Link>
            <Link to="/cv">CV <ArrowUpRight size={14} /></Link>
            <Link to="/contact">Contact <ArrowUpRight size={14} /></Link>
          </div>
        </div>

        <div className="footer-bottom">
          <span>© {new Date().getFullYear()} Flevian Ochoka</span>
          <span>TECHGHOST / NAIROBI, KENYA</span>
          <span>ONE IDEA · ONE SYSTEM · ONE PURPOSE</span>
        </div>
      </div>
    </footer>
  );
}
