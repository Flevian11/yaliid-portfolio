import { AlertTriangle, CheckCircle2, Info, X, XCircle } from 'lucide-react';
import type { ReactNode } from 'react';

type Kind = 'success' | 'error' | 'warning' | 'info';

const icons = { success: CheckCircle2, error: XCircle, warning: AlertTriangle, info: Info };

export default function FeedbackModal({
  kind = 'info', title, message, children, onClose, closeLabel = 'Close',
}: {
  kind?: Kind; title: string; message?: string; children?: ReactNode; onClose: () => void; closeLabel?: string;
}) {
  const Icon = icons[kind];
  return (
    <div className="modal-backdrop" role="presentation">
      <div className={`feedback-modal feedback-modal--${kind}`} role="dialog" aria-modal="true" aria-labelledby="feedback-title">
        <button className="modal-close" onClick={onClose} aria-label="Close"><X size={18} /></button>
        <div className="feedback-icon"><Icon /></div>
        <small className="feedback-kicker">{kind === 'success' ? 'COMPLETED' : kind === 'error' ? 'ACTION FAILED' : 'NOTICE'}</small>
        <h2 id="feedback-title">{title}</h2>
        {message && <p>{message}</p>}
        {children}
        <div className="modal-actions">
          <button className="admin-button primary" onClick={onClose}>{closeLabel}</button>
        </div>
      </div>
    </div>
  );
}

export function ConfirmModal({
  title, message, confirmLabel = 'Continue', danger = false, onCancel, onConfirm, loading = false,
}: {
  title: string; message: string; confirmLabel?: string; danger?: boolean; onCancel: () => void; onConfirm: () => void; loading?: boolean;
}) {
  return (
    <div className="modal-backdrop" role="presentation">
      <div className={`feedback-modal feedback-modal--${danger ? 'error' : 'warning'}`} role="dialog" aria-modal="true">
        <button className="modal-close" onClick={onCancel} aria-label="Close"><X size={18} /></button>
        <div className="feedback-icon"><AlertTriangle /></div>
        <small className="feedback-kicker">CONFIRM ACTION</small>
        <h2>{title}</h2>
        <p>{message}</p>
        <div className="modal-actions">
          <button className="admin-button secondary" onClick={onCancel} disabled={loading}>Cancel</button>
          <button className={`admin-button ${danger ? 'danger-button' : 'primary'}`} onClick={onConfirm} disabled={loading}>
            {loading ? 'Working…' : confirmLabel}
          </button>
        </div>
      </div>
    </div>
  );
}
