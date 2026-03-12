from fpdf import FPDF
import os

class ProjectPDF(FPDF):
    def header(self):
        self.set_font('Arial', 'B', 12)
        self.cell(0, 10, 'Tech Service Support - Project Code', 0, 1, 'C')
        self.ln(5)

    def footer(self):
        self.set_y(-15)
        self.set_font('Arial', 'I', 8)
        self.cell(0, 10, 'Page ' + str(self.page_no()) + '/{nb}', 0, 0, 'C')

    def chapter_title(self, label):
        self.set_font('Arial', 'B', 12)
        self.set_fill_color(200, 220, 255)
        self.cell(0, 6, label, 0, 1, 'L', 1)
        self.ln(4)

    def chapter_body(self, filepath):
        try:
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
        except FileNotFoundError:
            content = "File not found."
        except Exception as e:
            content = str(e)

        self.set_font('Courier', '', 10)
        # Handle unicode characters that might break FPDF (latin-1)
        content = content.encode('latin-1', 'replace').decode('latin-1')
        self.multi_cell(0, 5, content)
        self.ln()

    def add_file(self, filepath):
        self.add_page()
        self.chapter_title(filepath)
        self.chapter_body(filepath)

pdf = ProjectPDF()
pdf.alias_nb_pages()

base_dir = "c:/xampp/htdocs/ts/"

files = [
    "setup.sql",
    "inc/db.php",
    "css/style.css",
    "inc/header.php",
    "inc/footer.php",
    "index.php",
    "contact.php",
    "register.php",
    "login.php",
    "logout.php",
    "user/dashboard.php",
    "user/providers.php",
    "user/request.php",
    "user/track.php",
    "user/profile.php",
    "provider/dashboard.php",
    "provider/requests.php",
    "provider/profile.php",
    "admin/dashboard.php",
    "admin/review_contacts.php",
    "admin/profile.php"
]

for file in files:
    full_path = os.path.join(base_dir, file)
    print(f"Processing: {file}")
    pdf.add_file(full_path)

output_path = os.path.join(base_dir, "Tech_Service_Project_Code.pdf")
pdf.output(output_path, 'F')
print(f"PDF Generated: {output_path}")
