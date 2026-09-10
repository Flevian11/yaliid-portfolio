<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Certification;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectFeature;
use App\Models\ProjectTechnology;
use App\Models\Service;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\SocialLink;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $email = trim((string) env('PORTFOLIO_EMAIL', ''));

        if ($email === '') {
            throw new RuntimeException(
                'PORTFOLIO_EMAIL is required before seeding. Add your exact portfolio email to backend/.env and run php artisan db:seed again.'
            );
        }

        DB::transaction(function () use ($email): void {
            $profile = Profile::updateOrCreate(
                ['id' => 1],
                [
                    'full_name' => 'Flevian Ochoka',
                    'professional_title' => 'Software Engineer',
                    'tagline' => 'I design and build practical digital systems that turn real problems into useful products.',
                    'bio' => 'Flevian Ochoka (TechGhost) is a software engineer and builder focused on practical web systems, business platforms, automation and digital products.',
                    'professional_summary' => 'I design and build maintainable digital products across web development, business systems, POS platforms, automation and digital experiences. My work combines engineering discipline with product thinking to turn operational requirements into useful software.',
                    'email' => $email,
                    'phone' => env('PORTFOLIO_PHONE'),
                    'location' => 'Nairobi, Kenya',
                    'availability_status' => 'available',
                    'availability_text' => 'Available for selected software, web and digital product projects.',
                    'is_active' => true,
                ]
            );

            $socials = [
                ['platform' => 'GitHub', 'label' => 'GitHub', 'url' => 'https://github.com/Flevian11', 'icon' => 'github', 'display_order' => 1],
                ['platform' => 'LinkedIn', 'label' => 'LinkedIn', 'url' => env('PORTFOLIO_LINKEDIN_URL'), 'icon' => 'linkedin', 'display_order' => 2],
            ];

            foreach ($socials as $social) {
                if (empty($social['url'])) {
                    continue;
                }

                SocialLink::updateOrCreate(
                    ['profile_id' => $profile->id, 'platform' => $social['platform']],
                    [...$social, 'profile_id' => $profile->id, 'is_visible' => true]
                );
            }

            $experiences = [
                [
                    'organization' => 'Blinken Tech Africa Ltd',
                    'position' => 'Software Engineer / Technology',
                    'employment_type' => 'Professional',
                    'location' => 'Kenya',
                    'start_date' => null,
                    'end_date' => null,
                    'summary' => 'Building practical digital systems and technology solutions for operational needs.',
                    'description' => 'Software engineering work spanning web applications, business systems, digital platforms and implementation support.',
                    'display_order' => 1,
                    'is_current' => true,
                ],
                [
                    'organization' => 'Quest Website Developers Ltd',
                    'position' => 'Software Engineer',
                    'employment_type' => 'Professional',
                    'location' => 'Kenya',
                    'start_date' => '2023-03-01',
                    'end_date' => '2023-12-31',
                    'summary' => 'Software engineering work across full-stack development, client applications, IT support and digital experiences.',
                    'description' => 'Participated in full-stack development using PHP and MySQL; developed desktop and web applications for clients; assisted with AR elements for web-based experiences; handled IT desk support and basic cybersecurity tasks; and collaborated on project planning and execution.',
                    'display_order' => 2,
                    'is_current' => false,
                ],
                [
                    'organization' => 'InfoTech Company',
                    'position' => 'Industrial Attachment (Intern)',
                    'employment_type' => 'Internship',
                    'location' => 'Nairobi, Kenya',
                    'start_date' => '2023-03-01',
                    'end_date' => '2023-07-31',
                    'summary' => 'Industrial attachment covering application development, IT support, troubleshooting and software quality assurance.',
                    'description' => 'Worked on desktop and web application development and maintenance, IT desk support, hardware and software troubleshooting, system testing and quality assurance, with exposure to enterprise software development workflows.',
                    'display_order' => 3,
                    'is_current' => false,
                ],
            ];

            foreach ($experiences as $experienceData) {
                Experience::updateOrCreate(
                    ['organization' => $experienceData['organization'], 'position' => $experienceData['position']],
                    $experienceData + ['is_current' => true, 'is_published' => true]
                );
            }

            $certifications = [
                [
                    'name' => 'Artificial Intelligence Career Essentials (AiCE)',
                    'issuing_organization' => 'ALX Africa',
                    'credential_id' => null,
                    'credential_url' => null,
                    'issue_date' => '2024-05-01',
                    'expiry_date' => null,
                    'does_not_expire' => true,
                    'description' => 'Career-focused artificial intelligence training covering AI concepts, tools and practical applications.',
                    'certificate_file' => null,
                    'display_order' => 1,
                    'is_published' => true,
                ],
                [
                    'name' => 'AI & Machine Learning Certification',
                    'issuing_organization' => 'Udacity / AWS',
                    'credential_id' => null,
                    'credential_url' => null,
                    'issue_date' => null,
                    'expiry_date' => null,
                    'does_not_expire' => true,
                    'description' => 'Advanced artificial intelligence and machine-learning training with AWS cloud integration.',
                    'certificate_file' => null,
                    'display_order' => 2,
                    'is_published' => true,
                ],
            ];

            foreach ($certifications as $certificationData) {
                Certification::updateOrCreate(
                    ['name' => $certificationData['name'], 'issuing_organization' => $certificationData['issuing_organization']],
                    $certificationData
                );
            }

            // Recommendation letters are intentionally not seeded as records because the actual
            // letter files are not present in this backend archive. The existing
            // Experience -> RecommendationLetter relationship will attach them when uploaded.

            $skillCategories = [
                'Software Engineering' => [
                    ['name' => 'Laravel', 'proficiency' => 90, 'is_featured' => true],
                    ['name' => 'PHP', 'proficiency' => 90, 'is_featured' => true],
                    ['name' => 'React', 'proficiency' => 88, 'is_featured' => true],
                    ['name' => 'TypeScript', 'proficiency' => 86, 'is_featured' => true],
                    ['name' => 'Node.js', 'proficiency' => 84, 'is_featured' => true],
                    ['name' => 'NestJS', 'proficiency' => 82, 'is_featured' => false],
                ],
                'Data & Infrastructure' => [
                    ['name' => 'MySQL', 'proficiency' => 88, 'is_featured' => true],
                    ['name' => 'PostgreSQL', 'proficiency' => 84, 'is_featured' => true],
                    ['name' => 'Prisma ORM', 'proficiency' => 80, 'is_featured' => false],
                    ['name' => 'Git & GitHub', 'proficiency' => 90, 'is_featured' => true],
                ],
                'Frontend & Product' => [
                    ['name' => 'Tailwind CSS', 'proficiency' => 88, 'is_featured' => true],
                    ['name' => 'Vite', 'proficiency' => 86, 'is_featured' => false],
                    ['name' => 'Inertia.js', 'proficiency' => 80, 'is_featured' => false],
                ],
            ];

            $categoryOrder = 1;
            foreach ($skillCategories as $categoryName => $skills) {
                $category = SkillCategory::updateOrCreate(
                    ['name' => $categoryName],
                    ['description' => null, 'display_order' => $categoryOrder++, 'is_published' => true]
                );

                foreach ($skills as $order => $skillData) {
                    Skill::updateOrCreate(
                        ['skill_category_id' => $category->id, 'name' => $skillData['name']],
                        $skillData + ['display_order' => $order + 1, 'is_published' => true]
                    );
                }
            }

            $projects = [
                [
                    'title' => 'YaliJobs',
                    'slug' => 'yalijobs',
                    'short_description' => 'AI-powered job application management with ATS-ready CV and application workflows.',
                    'description' => 'A job application manager designed to help applicants organize opportunities, tailor application materials and manage the application process from one place.',
                    'problem' => 'Job seekers often manage job links, CV versions, cover letters and application status across disconnected tools.',
                    'solution' => 'A centralized application workflow with job extraction, tailored documents and applicant management features.',
                    'results' => 'A structured workflow for managing applications and producing role-specific application materials.',
                    'project_type' => 'SaaS / Web Application',
                    'status' => 'Active',
                    'featured' => true,
                    'live_url' => 'https://jobs.yaliid.cloud',
                    'display_order' => 1,
                    'technologies' => ['React', 'Vite', 'TypeScript', 'NestJS', 'Prisma', 'PostgreSQL'],
                    'features' => ['Job description extraction', 'ATS-oriented CV generation', 'Tailored cover letters', 'Application tracking'],
                ],
                [
                    'title' => 'NGAMY POS',
                    'slug' => 'ngamy-pos',
                    'short_description' => 'A practical point-of-sale platform for product, inventory, sales and payment workflows.',
                    'description' => 'A business-focused POS system built around day-to-day retail operations, product catalogues, barcode workflows, receipts and payment integration.',
                    'problem' => 'Retail operations need a simple system that connects product records, sales workflows, receipts and payments without unnecessary complexity.',
                    'solution' => 'A centralized POS workflow covering product management, barcode scanning, receipt printing and M-Pesa payment flows.',
                    'results' => 'A practical foundation for running retail transactions and managing operational product data.',
                    'project_type' => 'Business System / POS',
                    'status' => 'Active',
                    'featured' => true,
                    'live_url' => 'https://ngamy.yaliid.cloud',
                    'display_order' => 2,
                    'technologies' => ['Laravel', 'PHP', 'MySQL', 'JavaScript', 'M-Pesa'],
                    'features' => ['Product catalogue', 'Barcode scanning', 'Receipt printing', 'M-Pesa payment workflow'],
                ],
                [
                    'title' => 'Learn With Flevian LMS',
                    'slug' => 'learn-with-flevian-lms',
                    'short_description' => 'A learning management platform with courses, assessments, achievements, certificates and administration.',
                    'description' => 'An LMS built to support structured learning, student progress, assignments, quizzes, achievements, certificates, payments and administrative workflows.',
                    'problem' => 'Learning programs need one system for course delivery, learner progress, assessment, access control and administration.',
                    'solution' => 'A full LMS workflow connecting public course discovery, enrollment, learning, assessment, achievements, certificates and administration.',
                    'results' => 'A scalable foundation for delivering and administering structured online learning programs.',
                    'project_type' => 'LMS / Web Application',
                    'status' => 'Active',
                    'featured' => true,
                    'live_url' => 'https://lwf.yaliid.cloud',
                    'display_order' => 3,
                    'technologies' => ['Laravel', 'React', 'TypeScript', 'Inertia.js', 'Vite', 'MySQL'],
                    'features' => ['Course management', 'Assignments and quizzes', 'Student progress', 'Achievements and certificates', 'Enrollment and payments'],
                ],
                [
                    'title' => 'YaliPrint',
                    'slug' => 'yaliprint',
                    'short_description' => 'A printing-press extension that connects to YaliID data through APIs and enables schools and organizations to request printing services.',
                    'description' => 'YaliPrint extends the YaliID ecosystem into physical print production by consuming YaliID data through APIs and providing printing services for schools and organizations.',
                    'problem' => 'Schools and organizations using digital identity data still need a practical way to turn that data into physical printed materials.',
                    'solution' => 'An API-connected printing workflow that accesses authorized YaliID data and routes it into print-service operations.',
                    'results' => 'A bridge between digital school identity records and physical printing services.',
                    'project_type' => 'SaaS / Printing Integration',
                    'status' => 'Active',
                    'featured' => true,
                    'live_url' => 'https://print.yaliid.cloud',
                    'display_order' => 4,
                    'technologies' => ['Laravel', 'REST APIs', 'YaliID'],
                    'features' => ['YaliID API integration', 'School printing workflows', 'Print-service requests', 'Data-to-print workflow'],
                ],
                [
                    'title' => 'Yasmin AI',
                    'slug' => 'yasmin-ai',
                    'short_description' => 'An AI-powered digital product within the YaliID ecosystem.',
                    'description' => 'Yasmin AI is an artificial-intelligence product within the YaliID ecosystem, built around AI-assisted digital capabilities.',
                    'problem' => 'Users need practical AI capabilities integrated into accessible digital products.',
                    'solution' => 'An AI-focused product designed to provide intelligent assistance through a dedicated web experience.',
                    'results' => 'A dedicated AI product and platform within the broader YaliID ecosystem.',
                    'project_type' => 'AI / Web Application',
                    'status' => 'Active',
                    'featured' => true,
                    'live_url' => 'https://yasmin.yaliid.cloud',
                    'display_order' => 5,
                    'technologies' => ['AI', 'Web Application'],
                    'features' => ['AI-assisted interaction', 'Dedicated AI web platform'],
                ],
                [
                    'title' => 'Leaders Education Complex',
                    'slug' => 'leaders-education-complex',
                    'short_description' => 'A school and education platform focused on holistic education and learner support.',
                    'description' => 'Leaders Education Complex is an education initiative focused on holistic learning, learner welfare and supporting children through education and related programs.',
                    'problem' => 'Education institutions need digital presence and systems that communicate their programs, values and services clearly.',
                    'solution' => 'A dedicated web platform for presenting the institution, its educational offering and its learner-support initiatives.',
                    'results' => 'A public digital presence for the education institution and its programs.',
                    'project_type' => 'Education / Web Platform',
                    'status' => 'Active',
                    'featured' => true,
                    'live_url' => 'https://leaderseducationcomplex.co.ke',
                    'display_order' => 6,
                    'technologies' => ['Web Development'],
                    'features' => ['Institution profile', 'Education information', 'Learner-support information'],
                ],
                [
                    'title' => 'YaliID',
                    'slug' => 'yaliid',
                    'short_description' => 'A school ID-card automation platform for student registration, ID generation, transactions and print workflows.',
                    'description' => 'YaliID is a school identity and ID-card automation platform that centralizes student registration, ID generation, templates, credits and transactions, audit logs, storage and print-order workflows.',
                    'problem' => 'Schools need a reliable way to manage student identity data and turn it into consistent, traceable ID cards and related print outputs.',
                    'solution' => 'A centralized school ID platform connecting registration, ID generation, templates, credits, auditability, storage and printing workflows.',
                    'results' => 'A structured digital identity workflow for schools from student registration through ID production and printing.',
                    'project_type' => 'SaaS / Education Technology',
                    'status' => 'Active',
                    'featured' => true,
                    'live_url' => 'https://yaliid.cloud',
                    'display_order' => 7,
                    'technologies' => ['Laravel', 'PHP', 'MySQL', 'REST APIs'],
                    'features' => ['Student registration', 'ID-card generation', 'Template management', 'Credits and transactions', 'Audit logs', 'Print-order workflow'],
                ],
            ];

            foreach ($projects as $projectData) {
                $technologies = $projectData['technologies'];
                $features = $projectData['features'];
                unset($projectData['technologies'], $projectData['features']);

                $project = Project::updateOrCreate(
                    ['slug' => $projectData['slug']],
                    $projectData + ['is_published' => true]
                );

                foreach ($technologies as $order => $technology) {
                    ProjectTechnology::updateOrCreate(
                        ['project_id' => $project->id, 'name' => $technology],
                        ['display_order' => $order + 1]
                    );
                }

                foreach ($features as $order => $feature) {
                    ProjectFeature::updateOrCreate(
                        ['project_id' => $project->id, 'title' => $feature],
                        ['description' => null, 'display_order' => $order + 1]
                    );
                }
            }

            $services = [
                ['name' => 'Custom Software Systems', 'slug' => 'custom-software-systems', 'short_description' => 'Business platforms and custom applications built around real operational requirements.', 'description' => 'Design and development of maintainable software systems for specific business workflows.', 'icon' => 'layers', 'display_order' => 1, 'is_featured' => true],
                ['name' => 'Web Development', 'slug' => 'web-development', 'short_description' => 'Responsive websites and web applications with clean architecture and thoughtful interaction.', 'description' => 'Frontend and backend development for modern, responsive web products.', 'icon' => 'code-2', 'display_order' => 2, 'is_featured' => true],
                ['name' => 'POS & Business Automation', 'slug' => 'pos-business-automation', 'short_description' => 'Operational systems that reduce manual work and connect everyday business processes.', 'description' => 'POS, workflow automation and integrations designed around practical business operations.', 'icon' => 'workflow', 'display_order' => 3, 'is_featured' => true],
                ['name' => 'Digital Product Design', 'slug' => 'digital-product-design', 'short_description' => 'Clear digital experiences and interfaces shaped around users and business goals.', 'description' => 'Interface and product experience work focused on clarity, usability and implementation quality.', 'icon' => 'sparkles', 'display_order' => 4, 'is_featured' => false],
            ];

            foreach ($services as $service) {
                Service::updateOrCreate(
                    ['slug' => $service['slug']],
                    $service + ['is_published' => true]
                );
            }

            $settings = [
                ['key' => 'site_name', 'value' => 'Flevian Ochoka', 'type' => 'string', 'group' => 'general'],
                ['key' => 'brand_name', 'value' => 'TechGhost', 'type' => 'string', 'group' => 'general'],
                ['key' => 'brand_line', 'value' => 'Software · Systems · Digital Products', 'type' => 'string', 'group' => 'general'],
                ['key' => 'site_tagline', 'value' => 'Build useful systems. Ship with intent.', 'type' => 'string', 'group' => 'general'],
                ['key' => 'site_location', 'value' => 'Nairobi, Kenya', 'type' => 'string', 'group' => 'general'],
                ['key' => 'primary_cta', 'value' => 'Start a project', 'type' => 'string', 'group' => 'general'],
            ];

            foreach ($settings as $setting) {
                SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
            }
        });
    }
}
