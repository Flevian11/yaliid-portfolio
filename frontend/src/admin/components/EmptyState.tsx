import type { LucideIcon } from 'lucide-react';
import type { ReactNode } from 'react';

export default function EmptyState({
  icon: Icon, title, description, action,
}: {
  icon: LucideIcon; title: string; description: string; action?: ReactNode;
}) {
  return (
    <div className="empty-state">
      <div className="empty-state__icon"><Icon size={24} /></div>
      <h3>{title}</h3>
      <p>{description}</p>
      {action}
    </div>
  );
}
