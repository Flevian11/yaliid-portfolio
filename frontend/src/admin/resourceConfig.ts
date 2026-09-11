import type { LucideIcon } from 'lucide-react';
import {
  Award, BriefcaseBusiness, FileText, FolderKanban, GraduationCap,
  Settings, UserRound, Wrench, MessageSquare, Sparkles,
} from 'lucide-react';

export type Field = {
  key: string;
  label: string;
  type?: 'text' | 'email' | 'url' | 'date' | 'number' | 'textarea' | 'checkbox' | 'select' | 'file';
  required?: boolean;
  options?: string[];
  accept?: string;
};

export type ResourceConfig = {
  key: string;
  title: string;
  singular: string;
  endpoint: string;
  icon: LucideIcon;
  fields: Field[];
  fileField?: string;
  createDisabled?: boolean;
};

export const resourceConfigs: ResourceConfig[] = [
  {
    key: 'profile', title: 'Profile', singular: 'profile', endpoint: '/admin/profile',
    icon: UserRound, createDisabled: true,
    fields: [
      { key: 'full_name', label: 'Full name', required: true },
      { key: 'professional_title', label: 'Professional title', required: true },
      { key: 'tagline', label: 'Tagline' },
      { key: 'bio', label: 'Bio', type: 'textarea' },
      { key: 'professional_summary', label: 'Professional summary', type: 'textarea' },
      { key: 'email', label: 'Email', type: 'email' }, { key: 'phone', label: 'Phone' },
      { key: 'location', label: 'Location' }, { key: 'availability_status', label: 'Availability status' },
      { key: 'availability_text', label: 'Availability text' }, { key: 'is_active', label: 'Active', type: 'checkbox' },
    ],
  },
  {
    key: 'experience', title: 'Experience', singular: 'experience', endpoint: '/admin/experiences',
    icon: BriefcaseBusiness,
    fields: [
      { key: 'organization', label: 'Organization', required: true }, { key: 'position', label: 'Position', required: true },
      { key: 'employment_type', label: 'Employment type' }, { key: 'location', label: 'Location' },
      { key: 'start_date', label: 'Start date', type: 'date' }, { key: 'end_date', label: 'End date', type: 'date' },
      { key: 'is_current', label: 'Current role', type: 'checkbox' }, { key: 'summary', label: 'Summary', type: 'textarea' },
      { key: 'description', label: 'Description', type: 'textarea' },
      { key: 'is_published', label: 'Published', type: 'checkbox' },
    ],
  },
  {
    key: 'education', title: 'Education', singular: 'education record', endpoint: '/admin/education',
    icon: GraduationCap,
    fields: [
      { key: 'institution', label: 'Institution', required: true }, { key: 'qualification', label: 'Qualification', required: true },
      { key: 'field_of_study', label: 'Field of study' }, { key: 'description', label: 'Description', type: 'textarea' },
      { key: 'start_date', label: 'Start date', type: 'date' }, { key: 'end_date', label: 'End date', type: 'date' },
      { key: 'is_current', label: 'Currently studying', type: 'checkbox' },
      { key: 'is_published', label: 'Published', type: 'checkbox' },
    ],
  },
  {
    key: 'certifications', title: 'Certifications', singular: 'certification', endpoint: '/admin/certifications',
    icon: Award, fileField: 'certificate_file',
    fields: [
      { key: 'name', label: 'Certification name', required: true }, { key: 'issuing_organization', label: 'Issuing organization' },
      { key: 'credential_id', label: 'Credential ID' }, { key: 'credential_url', label: 'Credential URL', type: 'url' },
      { key: 'issue_date', label: 'Issue date', type: 'date' }, { key: 'expiry_date', label: 'Expiry date', type: 'date' },
      { key: 'does_not_expire', label: 'Does not expire', type: 'checkbox' }, { key: 'description', label: 'Description', type: 'textarea' },
      { key: 'is_published', label: 'Published', type: 'checkbox' },
      { key: 'certificate_file', label: 'Certificate file', type: 'file', accept: '.pdf,.jpg,.jpeg,.png' },
    ],
  },
  {
    key: 'recommendation-letters', title: 'Recommendation Letters', singular: 'recommendation letter',
    endpoint: '/admin/recommendation-letters', icon: FileText, fileField: 'file',
    fields: [
      { key: 'experience_id', label: 'Experience ID', type: 'number' }, { key: 'title', label: 'Title', required: true },
      { key: 'issuer_name', label: 'Issuer name' }, { key: 'issuer_position', label: 'Issuer position' },
      { key: 'issuer_organization', label: 'Issuer organization' }, { key: 'issue_date', label: 'Issue date', type: 'date' },
      { key: 'description', label: 'Description', type: 'textarea' }, { key: 'is_published', label: 'Published', type: 'checkbox' },
      { key: 'file', label: 'Letter file', type: 'file', accept: '.pdf,.doc,.docx' },
    ],
  },
  {
    key: 'projects', title: 'Projects', singular: 'project', endpoint: '/admin/projects', icon: FolderKanban,
    fields: [
      { key: 'title', label: 'Title', required: true }, { key: 'slug', label: 'Slug', required: true },
      { key: 'short_description', label: 'Short description', type: 'textarea' }, { key: 'description', label: 'Description', type: 'textarea' },
      { key: 'problem', label: 'Problem', type: 'textarea' }, { key: 'solution', label: 'Solution', type: 'textarea' },
      { key: 'results', label: 'Results', type: 'textarea' }, { key: 'project_type', label: 'Project type' },
      { key: 'status', label: 'Status' }, { key: 'featured', label: 'Featured', type: 'checkbox' },
      { key: 'github_url', label: 'GitHub URL', type: 'url' }, { key: 'live_url', label: 'Live URL', type: 'url' },
      { key: 'start_date', label: 'Start date', type: 'date' }, { key: 'end_date', label: 'End date', type: 'date' },
      { key: 'is_published', label: 'Published', type: 'checkbox' },
    ],
  },
  {
    key: 'services', title: 'Services', singular: 'service', endpoint: '/admin/services', icon: Wrench,
    fields: [
      { key: 'name', label: 'Name', required: true }, { key: 'slug', label: 'Slug', required: true },
      { key: 'short_description', label: 'Short description', type: 'textarea' }, { key: 'description', label: 'Description', type: 'textarea' },
      { key: 'icon', label: 'Icon' }, { key: 'is_featured', label: 'Featured', type: 'checkbox' }, { key: 'is_published', label: 'Published', type: 'checkbox' },
    ],
  },
  {
    key: 'skills', title: 'Skills', singular: 'skill', endpoint: '/admin/skills', icon: Settings,
    fields: [
      { key: 'skill_category_id', label: 'Skill category ID', type: 'number', required: true }, { key: 'name', label: 'Name', required: true },
      { key: 'description', label: 'Description', type: 'textarea' }, { key: 'proficiency', label: 'Proficiency (%)', type: 'number' },
      { key: 'is_featured', label: 'Featured', type: 'checkbox' }, { key: 'is_published', label: 'Published', type: 'checkbox' },
    ],
  },
  {
    key: 'achievements', title: 'Achievements', singular: 'achievement', endpoint: '/admin/achievements',
    icon: Award,
    fields: [
      { key: 'experience_id', label: 'Experience ID', type: 'number' },
      { key: 'title', label: 'Title', required: true },
      { key: 'description', label: 'Description', type: 'textarea' },
      { key: 'is_published', label: 'Published', type: 'checkbox' },
    ],
  },
  {
    key: 'testimonials', title: 'Testimonials', singular: 'testimonial', endpoint: '/admin/testimonials',
    icon: MessageSquare,
    fields: [
      { key: 'name', label: 'Name', required: true },
      { key: 'organization', label: 'Organization' },
      { key: 'position', label: 'Position' },
      { key: 'content', label: 'Testimonial', type: 'textarea', required: true },
      { key: 'photo', label: 'Photo path' },
      { key: 'rating', label: 'Rating', type: 'number' },
      { key: 'is_featured', label: 'Featured', type: 'checkbox' },
      { key: 'is_published', label: 'Published', type: 'checkbox' },
    ],
  },
  {
    key: 'advertisements', title: 'Advertisements', singular: 'advertisement', endpoint: '/admin/advertisements',
    icon: Sparkles,
    fields: [
      { key: 'title', label: 'Title', required: true },
      { key: 'description', label: 'Description', type: 'textarea' },
      { key: 'image_path', label: 'Image path' },
      { key: 'destination_url', label: 'Destination URL', type: 'url' },
      { key: 'position', label: 'Position' },
      { key: 'start_at', label: 'Start date & time', type: 'text' },
      { key: 'end_at', label: 'End date & time', type: 'text' },
      { key: 'is_active', label: 'Active', type: 'checkbox' },
    ],
  }
];
