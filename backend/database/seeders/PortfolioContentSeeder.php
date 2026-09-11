<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\Project;
use App\Models\ProjectFeature;
use App\Models\ProjectLink;
use App\Models\ProjectTechnology;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortfolioContentSeeder extends Seeder
{
    /**
     * Seed the portfolio's extended public content without touching the
     * existing profile, experience, education, skills or service seed data.
     *
     * Projects are upserted by slug and their child features, technologies
     * and links are rebuilt so rerunning this seeder stays deterministic.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $projects = [
                [
                    'title' => 'YaliJobs',
                    'slug' => 'yalijobs',
                    'short_description' => 'An AI-powered job application workspace that turns job descriptions into structured application workflows, tailored documents and organized application tracking.',
                    'description' => 'YaliJobs is a full job-application management platform built to reduce the fragmentation that comes with applying for multiple roles. It brings opportunity capture, job-description analysis, application tracking and document preparation into one workspace. The platform is designed around the practical steps a candidate repeats for every application: understanding the role, identifying relevant requirements, preparing a targeted CV, producing a matching cover letter and keeping a clear record of what was submitted. Its AI-assisted workflow helps transform raw job descriptions into structured information that can drive more relevant application materials, while the application manager keeps opportunities and their progress organized. The result is a focused SaaS workflow for moving from a discovered vacancy to a complete, trackable application without maintaining scattered documents and spreadsheets.',
                    'problem' => 'Job seekers frequently move between job boards, document editors, spreadsheets and email while maintaining multiple CV versions and application records. This makes it easy to lose application context, miss deadlines or submit generic materials that do not reflect the specific role.',
                    'solution' => 'YaliJobs centralizes the application lifecycle. A job description can be captured and structured, important requirements can be identified, application documents can be tailored to the opportunity, and the resulting application can be tracked from preparation through submission and follow-up.',
                    'results' => 'The platform provides a repeatable, organized workflow for turning individual vacancies into role-specific applications while keeping application history, documents and status information together in one system.',
                    'project_type' => 'SaaS / AI Web Application',
                    'status' => 'Active',
                    'featured' => true,
                    'github_url' => null,
                    'live_url' => 'https://jobs.yaliid.cloud',
                    'display_order' => 1,
                    'technologies' => ['React', 'Vite', 'TypeScript', 'NestJS', 'Prisma', 'PostgreSQL', 'AI'],
                    'features' => ['Job description extraction', 'ATS-oriented CV generation', 'Tailored cover letters', 'Application tracking'],
                ],
                [
                    'title' => 'NGAMY POS',
                    'slug' => 'ngamy-pos',
                    'short_description' => 'A retail point-of-sale system connecting product catalogues, stock, sales, receipts, barcode workflows and M-Pesa payment operations.',
                    'description' => 'NGAMY POS is a practical retail operations platform designed around the reality of a busy sales counter. It connects the product catalogue to inventory, sales processing, receipt generation and payment workflows so that a transaction is more than a simple sale record. Product and stock information can be managed centrally, barcode-based workflows can speed up item selection, receipts can be produced for completed transactions, and M-Pesa workflows can support mobile-money payments. The system is intended to reduce the duplication that occurs when product records, stock movements, sales and payment information are handled separately. Its value is in bringing the operational pieces of a retail business into one connected workflow that staff can use during day-to-day trading.',
                    'problem' => 'Retail businesses need accurate product and stock information at the point of sale, while also keeping sales, receipts and payment records consistent. Disconnected tools create duplicate work and make reconciliation harder.',
                    'solution' => 'NGAMY POS combines catalogue management, barcode workflows, stock-aware sales processing, receipt printing and M-Pesa payment operations into one business system so the transaction and its underlying records stay connected.',
                    'results' => 'A connected retail workflow that gives the business a single operational path from product selection and sale through receipt generation and payment recording.',
                    'project_type' => 'Business System / POS',
                    'status' => 'Active',
                    'featured' => true,
                    'github_url' => null,
                    'live_url' => 'https://ngamy.yaliid.cloud',
                    'display_order' => 2,
                    'technologies' => ['Laravel', 'PHP', 'MySQL', 'JavaScript', 'M-Pesa'],
                    'features' => ['Product catalogue', 'Barcode scanning', 'Inventory workflows', 'Receipt printing', 'M-Pesa payment workflow'],
                ],
                [
                    'title' => 'Learn With Flevian LMS',
                    'slug' => 'learn-with-flevian-lms',
                    'short_description' => 'A live learning management system covering course discovery, enrollment, lessons, assessments, assignments, progress, achievements, payments and certificates.',
                    'description' => 'Learn With Flevian is a complete digital learning environment built around the full learner journey rather than only course delivery. Students can discover courses, enroll, work through structured lessons and topics, submit assignments, take quizzes and track their progress from a central dashboard. The platform also supports achievements and certificates so completed learning has a visible outcome. On the administrative side, course providers can manage students, courses, lessons, assignments, assessments, submissions, grades, enrollments, payments and certificate issuance. The system also supports M-Pesa payment workflows for paid learning opportunities and configurable AI-assisted functionality. It is live and actively developed, with the public platform and open-source repository maintained as part of the Learn With Flevian ecosystem.',
                    'problem' => 'Learning programs often become fragmented when course content, assessments, submissions, payments, progress tracking and certificates are handled through separate systems. That fragmentation increases operational work for administrators and makes the learner journey harder to follow.',
                    'solution' => 'Learn With Flevian brings the learning lifecycle into one web platform: discover a course, enroll, learn, submit work, complete assessments, track progress, receive recognition and obtain certificates while administrators manage the same lifecycle centrally.',
                    'results' => 'A live LMS that provides a structured learning journey for students and a centralized operating environment for educators and administrators.',
                    'project_type' => 'LMS / Web Application',
                    'status' => 'Live',
                    'featured' => true,
                    'github_url' => 'https://github.com/Flevian11/lwf-lms',
                    'live_url' => 'https://lwf.yaliid.cloud',
                    'display_order' => 3,
                    'technologies' => ['Laravel', 'React', 'TypeScript', 'Inertia.js', 'Vite', 'MySQL'],
                    'features' => ['Course discovery and enrollment', 'Lessons and topics', 'Assignments and submissions', 'Quizzes and assessments', 'Progress tracking', 'Achievements and certificates'],
                ],
                [
                    'title' => 'YaliPrint',
                    'slug' => 'yaliprint',
                    'short_description' => 'A YaliID-connected printing platform that turns authorized identity data into practical school and organizational print-service workflows.',
                    'description' => 'YaliPrint extends the YaliID ecosystem beyond digital identity management into physical production. The platform is designed to access authorized YaliID data through APIs and use that information within printing workflows, allowing schools and organizations to request or produce printed materials without repeatedly re-entering the same identity information. This creates a practical bridge between structured digital records and the physical outputs that institutions still depend on, such as identity cards and related printed materials. The system is positioned as a printing-press extension of the wider YaliID ecosystem, with the goal of making data-to-print operations more consistent, traceable and efficient.',
                    'problem' => 'Digital identity systems can stop at data management even though schools and organizations still need physical cards and printed materials. Re-entering identity information during production creates unnecessary duplication and opportunities for errors.',
                    'solution' => 'YaliPrint connects to authorized YaliID data through APIs and uses those records inside the print-production workflow, allowing physical materials to be generated from information that already exists in the identity system.',
                    'results' => 'A practical integration between digital identity records and print fulfilment, reducing duplicate data entry and creating a more direct path from managed records to physical output.',
                    'project_type' => 'SaaS / Printing Integration',
                    'status' => 'Live',
                    'featured' => true,
                    'github_url' => 'https://github.com/Flevian11/print',
                    'live_url' => 'https://print.yaliid.cloud',
                    'display_order' => 4,
                    'technologies' => ['Laravel', 'REST APIs', 'YaliID', 'MySQL'],
                    'features' => ['YaliID API integration', 'School printing workflows', 'Print-service requests', 'Data-to-print workflow'],
                ],
                [
                    'title' => 'Yasmin AI',
                    'slug' => 'yasmin-ai',
                    'short_description' => 'A self-hosted conversational AI platform combining a Laravel web layer, Python AI services, persistent chat memory and local Ollama models.',
                    'description' => 'Yasmin AI is a modular conversational AI platform designed around the idea that an AI assistant can be self-hosted and composed from several clear layers. The Laravel application provides the web experience, authentication and conversation management, while Python services expose the AI processing layer and Ollama provides local large-language-model inference. Conversations and chat metadata are persisted so users can return to previous sessions instead of treating every interaction as a disposable request. The architecture separates the user-facing application from the inference service, making it possible to evolve the AI backend without rebuilding the entire web experience. The project is also designed with a local-first approach, allowing AI processing to remain close to the application environment rather than depending entirely on external AI APIs.',
                    'problem' => 'A useful AI assistant needs persistent conversations, session management and a maintainable inference architecture. A single tightly coupled chat endpoint becomes difficult to extend when the application needs different models, local inference or additional AI services.',
                    'solution' => 'Yasmin AI separates the Laravel web application, conversation storage, AI gateway and Python inference services, with Ollama providing local model execution. This creates a modular path from the browser to persistent chat data and then to the selected AI runtime.',
                    'results' => 'A working self-hosted AI assistant architecture with persistent multi-session conversations, modular AI services and local LLM execution.',
                    'project_type' => 'AI / Conversational Platform',
                    'status' => 'Live',
                    'featured' => true,
                    'github_url' => 'https://github.com/Flevian11/yasmin_ai',
                    'live_url' => 'https://yasmin.yaliid.cloud',
                    'display_order' => 5,
                    'technologies' => ['Laravel', 'PHP', 'Python', 'FastAPI', 'Flask', 'Ollama', 'SQLite', 'Tailwind CSS'],
                    'features' => ['Persistent multi-session chat', 'Conversation history', 'Automatic conversation titling', 'Local LLM inference', 'REST AI endpoints', 'Modular AI pipeline'],
                ],
                [
                    'title' => 'Leaders Education Complex',
                    'slug' => 'leaders-education-complex',
                    'short_description' => 'A responsive institutional website presenting Leaders Education Complex, its educational offering, identity and information for prospective families.',
                    'description' => 'Leaders Education Complex is a public-facing education website created to give the institution a clear and accessible digital presence. The experience is structured around the information families and the wider community need when learning about a school: who the institution is, what it offers, its educational identity and the services or support available to learners. The project focuses on presenting institutional information in a more organized and approachable form than disconnected social posts or static documents can provide. It also gives the institution a consistent web destination that can be shared with prospective families and other stakeholders. The result is a dedicated digital front door for the school, designed to communicate its identity and educational offering clearly across modern devices.',
                    'problem' => 'Schools need a reliable public digital destination where prospective families can understand the institution, its educational offering and the information that matters when considering enrollment.',
                    'solution' => 'A dedicated responsive institutional website organizes the school’s identity, programs and learner-focused information into a single public experience that can be accessed and shared easily.',
                    'results' => 'A clearer online presence for the institution and a centralized place for prospective families and stakeholders to access school information.',
                    'project_type' => 'Education / Web Platform',
                    'status' => 'Active',
                    'featured' => false,
                    'github_url' => null,
                    'live_url' => 'https://leaderseducationcomplex.co.ke',
                    'display_order' => 6,
                    'technologies' => ['Web Development', 'Responsive Design'],
                    'features' => ['Institution profile', 'Education information', 'Learner-support information', 'Responsive public website'],
                ],
                [
                    'title' => 'YaliID',
                    'slug' => 'yaliid',
                    'short_description' => 'A school identity platform connecting student registration, ID-card generation, templates, transactions, audit trails and printing workflows.',
                    'description' => 'YaliID is the identity and ID-card automation platform at the center of a broader school-data and printing workflow. It is designed to move institutions away from fragmented spreadsheets and manual card preparation by keeping student identity records structured and connecting those records to ID-card production. The system includes student registration, reusable ID templates, credits and transaction tracking, audit logs, storage and print-order workflows. This creates a traceable path from the moment a student is registered to the production and fulfilment of their physical identity card. YaliID also provides the data foundation used by related services such as YaliPrint, where authorized identity records can be consumed through APIs for physical print production.',
                    'problem' => 'Schools need accurate student identity records and a repeatable way to turn those records into consistent ID cards. Manual preparation makes updates, auditing and large batches difficult to control.',
                    'solution' => 'YaliID centralizes student identity data and connects registration, template-driven ID generation, transaction controls, auditability, storage and print ordering into one workflow.',
                    'results' => 'A structured school identity workflow that supports repeatable ID production, traceability and integration with downstream printing services.',
                    'project_type' => 'SaaS / Education Technology',
                    'status' => 'Active',
                    'featured' => true,
                    'github_url' => null,
                    'live_url' => 'https://yaliid.cloud',
                    'display_order' => 7,
                    'technologies' => ['Laravel', 'PHP', 'MySQL', 'REST APIs', 'React', 'TypeScript'],
                    'features' => ['Student registration', 'ID-card generation', 'Template management', 'Credits and transactions', 'Audit logs', 'Print-order workflow'],
                ],
                [
                    'title' => 'EchoFauna',
                    'slug' => 'echofauna',
                    'short_description' => 'An immersive AI-driven digital museum combining 3D species exploration, extinction storytelling, a holographic archive and experimental AI reconstruction.',
                    'description' => 'EchoFauna is an immersive digital museum that uses web technology to explore extinct species through a combination of science, visual storytelling and experimental AI. The experience is designed around a cinematic hero sequence, an interactive holographic archive and a globe that highlights extinction hotspots. Visitors can explore featured species through 3D models, extinction facts and soundscapes, then move through scroll-driven stories that follow the path from habitat and decline to extinction and speculative digital revival. The concept also includes an AI Lab where users can experiment with traits and reconstruction prompts, an ecosystem simulator that grows as species are explored, and a conservation hub connecting the historical story of extinction to action around endangered species today. The repository identifies Three.js, GSAP, WebGL, Tailwind CSS and JavaScript as core technologies.',
                    'problem' => 'Information about extinct species can be scientifically valuable but difficult to make emotionally engaging and interactive for a broad web audience.',
                    'solution' => 'EchoFauna turns extinction research and conservation storytelling into an immersive digital museum using 3D visualization, interactive exploration, cinematic transitions and experimental AI reconstruction concepts.',
                    'results' => 'A visually ambitious interactive experience that gives visitors multiple ways to explore extinct species while connecting scientific storytelling with conservation awareness.',
                    'project_type' => 'AI / Interactive Web Experience',
                    'status' => 'Active',
                    'featured' => true,
                    'github_url' => 'https://github.com/Flevian11/echofauna',
                    'live_url' => 'https://flevian11.github.io/echofauna',
                    'display_order' => 8,
                    'technologies' => ['HTML5', 'CSS3', 'JavaScript', 'Three.js', 'GSAP', 'Tailwind CSS', 'WebGL', 'AI'],
                    'features' => ['Holographic archive', '3D species exploration', 'Scroll-driven storytelling', 'AI Lab concept', 'Ecosystem simulator', 'Conservation action hub'],
                ],
                [
                    'title' => 'Whisper',
                    'slug' => 'whisper',
                    'short_description' => 'A secure real-time messaging MVP where encryption happens on the client and the backend operates only as a blind relay and ciphertext store.',
                    'description' => 'Whisper is a real-time communication prototype built around a deliberately strict security boundary: the server should never see plaintext messages. Encryption and decryption take place on the client, while the Node.js and Express backend receives encrypted payloads, stores ciphertext and broadcasts it through Socket.IO. The project uses LowDB for lightweight persistence and includes history retrieval and basic rate limiting. This architecture makes the server infrastructure intentionally untrusted from the perspective of message confidentiality. The client derives the cryptographic key locally and handles the sensitive transformation before a message leaves the user’s environment. The result is an MVP that demonstrates how real-time communication can be designed around client-side cryptography rather than treating the backend as a trusted holder of readable message content.',
                    'problem' => 'Traditional messaging backends often receive and process plaintext, meaning sensitive conversations remain exposed to the server infrastructure and anyone who gains inappropriate access to it.',
                    'solution' => 'Whisper moves encryption and decryption to the client and limits the backend to transporting, broadcasting and storing ciphertext, creating a blind-relay model for real-time communication.',
                    'results' => 'A working real-time encrypted messaging prototype that demonstrates client-side cryptography, ciphertext persistence and Socket.IO communication under an intentionally untrusted server model.',
                    'project_type' => 'Security / Real-Time Application',
                    'status' => 'Prototype',
                    'featured' => false,
                    'github_url' => 'https://github.com/Flevian11/whisper',
                    'live_url' => null,
                    'display_order' => 9,
                    'technologies' => ['React', 'Vite', 'Node.js', 'Express', 'Socket.IO', 'LowDB', 'CryptoJS', 'PBKDF2', 'AES'],
                    'features' => ['Client-side encryption', 'Real-time messaging', 'Blind relay backend', 'Encrypted message history', 'Panic / kill-switch mode', 'Basic abuse protection'],
                ],
                [
                    'title' => 'Arduino LED Simulation',
                    'slug' => 'arduino-led-simulation',
                    'short_description' => 'A beginner-friendly Wokwi simulation demonstrating Arduino Uno digital output by controlling an LED through a resistor and virtual breadboard.',
                    'description' => 'Arduino LED Simulation is a small embedded-systems project designed to make the first steps in Arduino programming and electronics easy to understand. The repository contains an Arduino Uno circuit represented in Wokwi, with an LED connected to a digital output through a resistor and the remaining circuit completed on a virtual breadboard. The sketch demonstrates the basic structure of an Arduino program and uses a digital pin to switch the LED between HIGH and LOW states. Because the entire circuit is simulated, the project can be tested without physical components while still exposing the learner to the relationship between software instructions, microcontroller pins and an electronic output. It is intentionally simple, making it useful as a foundation for later sensor, actuator and automation projects.',
                    'problem' => 'Beginners often have to learn programming concepts, electronics wiring and hardware behavior at the same time, making the first Arduino experiment harder to reproduce consistently.',
                    'solution' => 'A compact Wokwi circuit combines an Arduino Uno, LED, resistor and virtual breadboard with a small sketch that demonstrates digital output and timed LED control.',
                    'results' => 'A repeatable virtual electronics exercise that demonstrates the connection between Arduino code, digital output pins and physical-style circuit behavior.',
                    'project_type' => 'Embedded Systems / Simulation',
                    'status' => 'Completed',
                    'featured' => false,
                    'github_url' => 'https://github.com/Flevian11/arduino-led-simulation',
                    'live_url' => null,
                    'display_order' => 10,
                    'technologies' => ['Arduino', 'C++', 'Wokwi'],
                    'features' => ['Arduino Uno simulation', 'LED control', 'Digital output demonstration', 'Virtual circuit testing'],
                ],
                [
                    'title' => 'Arduino Traffic Light Simulation',
                    'slug' => 'arduino-traffic-light-simulation',
                    'short_description' => 'A Wokwi Arduino traffic controller that coordinates red, yellow and green LEDs through the real-world Red → Green → Yellow sequence.',
                    'description' => 'Arduino Traffic Light Simulation builds on basic digital-output concepts by coordinating three LEDs as a miniature traffic signal. The project uses an Arduino Uno, red, yellow and green LEDs, resistors and a simulated breadboard inside Wokwi. The program cycles automatically through the expected traffic-light states, applying delays between transitions so that the signal behaves like a simplified real-world controller. This makes the project a useful introduction to sequential logic, timing and multi-output coordination: instead of controlling one device, the microcontroller must maintain a predictable state sequence across several outputs. Because the circuit is virtual, the logic can be tested and observed without physical electronics while still following the same conceptual structure used by a basic hardware implementation.',
                    'problem' => 'A single LED demonstrates digital output, but embedded systems also need to coordinate several outputs according to an ordered state machine and timed transitions.',
                    'solution' => 'The project uses three Arduino-controlled LEDs to represent Stop, Wait and Go states and cycles them through the Red → Green → Yellow sequence with programmed delays.',
                    'results' => 'A compact simulation demonstrating multi-output control, sequential state changes and timing logic in a form that can be tested safely in a browser-based electronics simulator.',
                    'project_type' => 'Embedded Systems / Simulation',
                    'status' => 'Completed',
                    'featured' => false,
                    'github_url' => 'https://github.com/Flevian11/arduino-traffic-light-simulation',
                    'live_url' => null,
                    'display_order' => 11,
                    'technologies' => ['Arduino', 'C++', 'Wokwi'],
                    'features' => ['Three-light traffic sequence', 'Arduino Uno', 'Digital output control', 'Timed state transitions', 'Virtual circuit simulation'],
                ],
                [
                    'title' => 'BeriBakes Bakery Management System',
                    'slug' => 'beribakes',
                    'short_description' => 'A bakery e-commerce and management system combining online product ordering with administration for products, customers, stock, finances and sales reporting.',
                    'description' => 'BeriBakes is a web-based bakery management system that connects the customer shopping journey with the operational work behind it. Customers can browse bakery products, add items to a cart and complete an order through the storefront, while administrators use a centralized dashboard to manage products, customers, orders and business records. The repository includes dedicated areas for authentication, cart handling, product management, administration, database storage and order processing. The system also tracks inventory and financial information, giving the business a more complete view than a storefront alone would provide. Built with PHP and MySQL and structured for a traditional XAMPP deployment, BeriBakes demonstrates how a small commerce operation can be represented as an end-to-end digital workflow from product listing to order processing and reporting.',
                    'problem' => 'Manual bakery operations can scatter product information, customer records, orders, stock and financial transactions across notebooks or unrelated tools, making the business harder to monitor and reconcile.',
                    'solution' => 'BeriBakes combines a customer-facing storefront and shopping cart with an administrative system for products, customers, orders, inventory, financial records and sales reporting.',
                    'results' => 'An end-to-end bakery workflow that connects online ordering with the operational records required to manage day-to-day business activity.',
                    'project_type' => 'E-Commerce / Business System',
                    'status' => 'Completed',
                    'featured' => false,
                    'github_url' => 'https://github.com/Flevian11/Beribakes',
                    'live_url' => null,
                    'display_order' => 12,
                    'technologies' => ['PHP', 'MySQL', 'HTML5', 'CSS3', 'JavaScript', 'XAMPP'],
                    'features' => ['Product catalogue', 'Shopping cart', 'Online checkout', 'Order management', 'Inventory tracking', 'Financial ledger', 'Sales reports'],
                ],
                [
                    'title' => 'M-Pesa Simulator',
                    'slug' => 'mpesa-simulator',
                    'short_description' => 'A C++ mobile-money simulation modelling users, wallets, agents, ATMs, peer-to-peer transfers, authentication, fees, limits and transaction auditing.',
                    'description' => 'M-Pesa Simulator v2.0 is an object-oriented C++ console application that models the core mechanics of a mobile-money ecosystem. The system represents users and wallets while supporting multiple transaction channels, including agent banking, ATM services and peer-to-peer transfers. It includes PIN-based authentication with account lockout behavior, transaction fees and limits, unique transaction identifiers and an audit trail for completed operations. Data is persisted to files so the application can maintain state between runs and recover its stored information. Rather than being a simple menu demonstration, the project treats mobile money as a collection of interacting financial entities and transaction rules, making it useful for studying object-oriented design, state management, authentication and the operational logic behind digital financial services.',
                    'problem' => 'Mobile-money systems combine authentication, balances, transaction rules, fees, limits and multiple service channels. Understanding those interactions is easier with a complete executable model.',
                    'solution' => 'A self-contained C++ simulation models users, wallets, agents, ATMs and transactions while enforcing PIN authentication, financial controls, persistence and transaction auditing.',
                    'results' => 'A detailed executable model of mobile-money operations that demonstrates object-oriented system design, transaction integrity and persistent financial state.',
                    'project_type' => 'C++ / Financial Simulation',
                    'status' => 'Completed',
                    'featured' => false,
                    'github_url' => 'https://github.com/Flevian11/mpesa-simulator',
                    'live_url' => null,
                    'display_order' => 13,
                    'technologies' => ['C++', 'C++11', 'STL', 'File I/O'],
                    'features' => ['PIN authentication', 'Agent banking', 'ATM withdrawals', 'Peer-to-peer transfers', 'Transaction audit trail', 'Fees and limits', 'File-based persistence'],
                ],
                [
                    'title' => 'Synergy',
                    'slug' => 'synergy',
                    'short_description' => 'A PHP/MySQL membership system organized around authentication, member records, database-backed operations, logging and administrative workflows.',
                    'description' => 'Synergy is a PHP/MySQL web application centered on membership-oriented workflows. Its repository is organized into authentication, member management, database access, logs, error handling and supporting administrative pages, providing the structure expected from a practical CRUD-based business application. The system demonstrates how a membership workflow can be moved from manual records into authenticated web interfaces where data can be created, reviewed and updated through controlled operations. It also keeps operational logging and error handling close to the application so that changes and failures can be tracked rather than disappearing into an unmanaged process. The project is intentionally focused on the fundamentals of a database-backed web system: authentication, structured records, server-side processing and maintainable separation between operational areas.',
                    'problem' => 'Member-based organizations need controlled access to structured records and repeatable update workflows rather than relying on scattered spreadsheets or manual files.',
                    'solution' => 'Synergy provides authenticated PHP/MySQL workflows for member records, database-backed CRUD operations, logging and administrative management.',
                    'results' => 'A functional membership-management foundation demonstrating the core architecture of a server-rendered, database-backed organizational system.',
                    'project_type' => 'PHP / Membership System',
                    'status' => 'Completed',
                    'featured' => false,
                    'github_url' => 'https://github.com/Flevian11/synergy',
                    'live_url' => null,
                    'display_order' => 14,
                    'technologies' => ['PHP', 'MySQL', 'HTML', 'CSS', 'JavaScript'],
                    'features' => ['Authentication', 'Member management', 'Database-backed records', 'Operational logging', 'Administrative workflows'],
                ],
                [
                    'title' => 'AI Certificate Parser',
                    'slug' => 'ai-certificate-parser',
                    'short_description' => 'An offline-first certificate-processing pipeline that uses OCR and local LLM extraction to produce structured verification data, letters and styled PDFs.',
                    'description' => 'AI Certificate Parser is an offline-first document-processing application built to turn certificate documents into structured verification outputs. A certificate can be supplied as a PDF or image, after which Tesseract OCR extracts the document text. A local language model running through Ollama then converts that unstructured text into structured fields, while validation logic checks important certificate and identification values. The system can generate a professional verification letter and a styled verification PDF from the extracted information. Supporting modules provide TTL-based caching, request logging and a FastAPI service layer, while the project includes examples, tests and screenshots that document the workflow. The architecture keeps the AI processing local, meaning the core extraction path does not depend on external AI APIs and can be operated in environments where document privacy and offline processing are important.',
                    'problem' => 'Certificate verification often requires manually reading documents, extracting identifiers and names, validating the information and preparing consistent verification paperwork.',
                    'solution' => 'The parser combines PDF/image upload, OCR, local LLM extraction, validation, professional letter generation and PDF rendering into one automated processing pipeline.',
                    'results' => 'A reusable offline-first verification workflow that transforms unstructured certificate documents into structured data and standardized verification documents.',
                    'project_type' => 'AI / Document Processing',
                    'status' => 'Active Development',
                    'featured' => true,
                    'github_url' => 'https://github.com/Flevian11/ai-certificate-parser',
                    'live_url' => null,
                    'display_order' => 15,
                    'technologies' => ['Python', 'FastAPI', 'Uvicorn', 'Tesseract OCR', 'Ollama', 'pdfplumber', 'ReportLab'],
                    'features' => ['PDF/image certificate upload', 'OCR extraction', 'Local LLM field extraction', 'Certificate validation', 'Verification-letter generation', 'Styled PDF generation', 'TTL caching', 'Request logging'],
                ],
            ];

            foreach ($projects as $data) {
                $technologies = $data['technologies'];
                $features = $data['features'];
                $githubUrl = $data['github_url'];
                $liveUrl = $data['live_url'];

                unset($data['technologies'], $data['features'], $data['github_url'], $data['live_url']);

                $project = Project::updateOrCreate(['slug' => $data['slug']], $data + ['is_published' => true]);

                ProjectFeature::where('project_id', $project->id)->delete();
                ProjectTechnology::where('project_id', $project->id)->delete();
                ProjectLink::where('project_id', $project->id)->delete();

                foreach ($technologies as $order => $technology) {
                    ProjectTechnology::create([
                        'project_id' => $project->id,
                        'name' => $technology,
                        'display_order' => $order + 1,
                    ]);
                }

                foreach ($features as $order => $feature) {
                    ProjectFeature::create([
                        'project_id' => $project->id,
                        'title' => $feature,
                        'description' => null,
                        'display_order' => $order + 1,
                    ]);
                }

                $links = [];
                if ($githubUrl) {
                    $links[] = ['label' => 'View source on GitHub', 'url' => $githubUrl, 'type' => 'github'];
                }
                if ($liveUrl) {
                    $links[] = ['label' => 'Open live project', 'url' => $liveUrl, 'type' => 'live'];
                }

                foreach ($links as $order => $link) {
                    ProjectLink::create($link + [
                        'project_id' => $project->id,
                        'display_order' => $order + 1,
                    ]);
                }
            }

            // This is deliberately a sample advertisement. Replace its image
            // from Admin > Advertisements with the real uploaded creative.
            Advertisement::updateOrCreate(
                ['title' => 'Build a Digital Product That Works'],
                [
                    'description' => 'Need a website, business system or custom digital product? Explore software development services by Flevian Ochoka.',
                    'image_path' => 'https://placehold.co/1200x500/png?text=YaliID+Sample+Advertisement',
                    'destination_url' => 'https://yaliid.cloud/request-service',
                    'position' => 'home',
                    'start_at' => null,
                    'end_at' => null,
                    'is_active' => true,
                    'display_order' => 1,
                ]
            );

            // These are clearly marked demo records and remain unpublished so
            // fabricated endorsements never appear publicly. Replace/edit them
            // from Admin > Testimonials when real testimonials are available.
            // These five records are structured testimonial drafts tied to actual portfolio work.
            // They remain unpublished until real client/collaborator wording is supplied; no invented
            // personal endorsement is presented as genuine public feedback.
            $samples = [
                ['name' => 'YaliJobs Project Feedback', 'organization' => 'YaliJobs', 'position' => 'Product / Project Stakeholder', 'content' => 'The YaliJobs workflow brings job discovery, application documents and application tracking into one focused workspace, making the process easier to organize and follow.', 'rating' => 5],
                ['name' => 'NGAMY POS Project Feedback', 'organization' => 'NGAMY POS', 'position' => 'Business System Stakeholder', 'content' => 'The POS workflow connects products, sales, inventory, receipts and payment operations into a much more practical day-to-day retail process.', 'rating' => 5],
                ['name' => 'Learn With Flevian Project Feedback', 'organization' => 'Learn With Flevian', 'position' => 'Platform Stakeholder', 'content' => 'The LMS brings courses, assignments, assessments, progress, payments and certificates together so the learning journey can be managed from one platform.', 'rating' => 5],
                ['name' => 'YaliPrint Project Feedback', 'organization' => 'YaliPrint', 'position' => 'Platform Stakeholder', 'content' => 'Connecting authorized YaliID data to printing workflows removes unnecessary duplication and creates a cleaner path from digital records to physical output.', 'rating' => 5],
                ['name' => 'EchoFauna Project Feedback', 'organization' => 'EchoFauna', 'position' => 'Project Collaborator', 'content' => 'EchoFauna turns an ambitious conservation concept into an immersive web experience that combines storytelling, interactive visuals and experimental AI ideas.', 'rating' => 5],
            ];

            foreach ($samples as $order => $sample) {
                Testimonial::updateOrCreate(
                    ['name' => $sample['name']],
                    $sample + [
                        'photo' => null,
                        'is_featured' => false,
                        'is_published' => false,
                        'display_order' => $order + 1,
                    ]
                );
            }
        });

        $this->command?->info('PortfolioContentSeeder completed: 15 projects upserted, project links refreshed, 1 sample advertisement seeded, and 5 structured unpublished testimonial drafts seeded.');
    }
}
