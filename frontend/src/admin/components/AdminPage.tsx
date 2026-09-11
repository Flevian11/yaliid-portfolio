import type { ReactNode } from 'react';
import { ArrowUpRight } from 'lucide-react';

export default function AdminPage({
  eyebrow, title, description, action, children,
}: {
  eyebrow: string; title: string; description?: string; action?: ReactNode; children: ReactNode;
}) {
  return (
    <section className="admin-page">
      <div className="admin-top">
        <div className="admin-heading">
          <small>{eyebrow}</small>
          <h1>{title}</h1>
          {description && <p>{description}</p>}
        </div>
        {action}
      </div>
      {children}
    </section>
  );
}

export function PanelTitle({ title, action }: { title: string; action?: ReactNode }) {
  return (
    <div className="panel-title">
      <h2>{title}</h2>
      {action || <ArrowUpRight size={16} />}
    </div>
  );
}
