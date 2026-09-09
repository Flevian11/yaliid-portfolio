export type SocialLink={id:number;platform:string;label?:string;url:string;icon?:string}
export type Profile={id?:number;full_name:string;professional_title:string;tagline?:string;bio?:string;professional_summary?:string;profile_photo?:string;hero_image?:string;email?:string;phone?:string;location?:string;availability_status?:string;availability_text?:string;cv_file?:string;cv_updated_at?:string;is_active?:boolean}
export type Achievement={id:number;title:string;description?:string}
export type RecommendationLetter={id:number;title:string;issuer_name?:string;file_path:string}
export type Experience={id:number;organization:string;position:string;employment_type?:string;location?:string;start_date?:string;end_date?:string;is_current:boolean;summary?:string;description?:string;achievements?:Achievement[];recommendation_letters?:RecommendationLetter[]}
export type Education={id:number;institution:string;qualification:string;field_of_study?:string;description?:string;start_date?:string;end_date?:string}
export type Certification={id:number;name:string;issuing_organization:string;credential_id?:string;credential_url?:string;issue_date?:string;certificate_file?:string}
export type Skill={id:number;name:string;description?:string;proficiency?:number}; export type SkillCategory={id:number;name:string;skills:Skill[]}
export type Project={id:number;title:string;slug:string;short_description?:string;description?:string;problem?:string;solution?:string;results?:string;project_type?:string;status?:string;featured:boolean;github_url?:string;live_url?:string;media?:{id:number;file_path:string;file_name:string;alt_text?:string;is_featured:boolean}[];features?:{id:number;title:string;description?:string}[];technologies?:{id:number;name:string}[]}
export type Service={id:number;name:string;slug:string;short_description?:string;description?:string;icon?:string}
export type Advertisement={id:number;title:string;description?:string;image_path:string;destination_url?:string;position:string}
export type Testimonial={id:number;name:string;organization?:string;position?:string;content:string;photo?:string;rating?:number}
export type PortfolioData={profile:Profile|null;experiences:Experience[];education:Education[];certifications:Certification[];skills:SkillCategory[];projects:Project[];services:Service[];advertisements:Advertisement[];testimonials:Testimonial[]}
