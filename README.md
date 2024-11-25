<p align="center"><img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fabouttell.wordpress.com%2F2019%2F04%2F15%2Fimplementation-of-the-test-run%2F&psig=AOvVaw2dp6tQKqzmeXpuP2PNyfbg&ust=1732591521191000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCLiXq8PE9okDFQAAAAAdAAAAABAE" alt="" style="width: 300px;"></p>

## About SIMS

The Security Information Management System (SIMS) is a comprehensive web-based platform designed to assist organizations in managing and documenting their security information effectively. The system simplifies the process of generating formal reports, enabling auditors to assess organizational risks and ensure compliance with security standards.

## Key Features

1. Automated PDF Report Generation

- Seamlessly generate professional, formal PDF reports tailored for auditors.
- Includes detailed risk assessments, asset classifications, and compliance summaries.

2. Risk Assessment Management
- Identify, evaluate, and classify risks associated with organizational assets.
- Categorize risks by severity to prioritize mitigation efforts.

3. User-Friendly Dashboard
- Visualize critical security metrics and asset status at a glance.
- Interactive charts and summaries for quick insights.

4. Compliance Tracking
- Manage and document security controls to ensure compliance with industry standards, such as ISO 27001.
- Facilitate internal and external audits with structured and accessible data.

5. Asset Management
- Centralize all organizational asset details in one system.
- Track their security posture, risk exposure, and associated documentation.

6. Role-Based Access Control
- Secure the platform with distinct roles and permissions.
-Allow specific access for admins, auditors, and team members based on their responsibilities.


## Technologies Used

- Backend: PHP (Core PHP or Laravel Framework for scalability)
- Frontend: HTML, CSS, JavaScript
- Database: MySQL
- Libraries & Tools:
  - TCPDF or DomPDF for PDF generation
  - Chart.js or Highcharts for data visualization
  - Authentication & Security libraries (e.g., JWT, bcrypt)


## Installation Guide

1. Clone the repository:
```python
git clone https://github.com/your-repository/sims.git
cd sims
```

2. Configure your .env file:
- Database credentials (e.g., DB_HOST, DB_USER, DB_PASS).
- Application URL and other settings.

3. Import the database schema:
- Locate the ```sims_database.sql``` file in the ```/database``` directory.
- Import it into your MySQL server using your preferred method (e.g., PHPMyAdmin, CLI).

4. Start the server:
- If using built-in PHP server:
```python
php -S localhost:8000
```

## Usage

1. Log in with your provided credentials based on your role (Admin, Auditor, or Team Member).
2. Navigate to the dashboard to view security metrics.
3. Use the Risk Assessment section to evaluate and document risks.
4. Generate PDF reports in the Reports section for audit purposes.

## Project Objectives

The main goal of SIMS is to provide a centralized, efficient, and reliable platform for managing an organization's security-related documentation. It aims to reduce manual effort, ensure compliance with standards like ISO 27001, and enhance overall security governance.

## Future Enhancements
- Integration with third-party vulnerability scanners for real-time asset risk updates.
- Advanced analytics and AI-driven insights for proactive security measures.
- Multi-language support for global usage.

##  Contribution
Contributions are welcome! Please fork the repository, make your changes, and submit a pull request.

## License

This project is licensed under the MIT License. See the LICENSE file for details.

