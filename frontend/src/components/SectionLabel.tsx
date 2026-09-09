export default function SectionLabel({ children }: { children: React.ReactNode }) {
  return (
    <div className="section-label">
      <i />
      <span>{children}</span>
    </div>
  );
}
