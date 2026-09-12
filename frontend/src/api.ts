import axios from 'axios';
import type { PortfolioData, Project, Service } from './types';

export const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || '/api/v1',
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
  withCredentials: true,
  withXSRFToken: true,
  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',
});

export const portfolioApi = {
  get: () => api.get<PortfolioData>('/portfolio').then(r => r.data),
  project: (slug: string) => api.get<Project>(`/projects/${slug}`).then(r => r.data),
  services: () => api.get<Service[]>('/services').then(r => r.data),
  cv: () => api.get('/cv').then(r => r.data),
  request: (p: unknown) => api.post('/service-requests', p).then(r => r.data),
  message: (p: unknown) => api.post('/messages', p).then(r => r.data),
};
