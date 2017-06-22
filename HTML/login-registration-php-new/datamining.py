from bs4 import BeautifulSoup
import requests
import pymysql

db = pymysql.connect("localhost","root","","mw", autocommit=True)
cursor = db.cursor()
cursor.execute("SELECT VERSION()")
data = cursor.fetchone()
print('=====================================')
print ("Database version : %s " % data)
print('=====================================')


page = requests.get("https://matriculaweb.unb.br/graduacao/oferta_dis.aspx?cod=163")
soup = BeautifulSoup(page.content, 'html.parser')

table = soup.find("table", {"class": "FrameCinza"})
records = {}

for row in table.findAll('tr'):
    col = row.findAll('td')
    code = col[0].string.strip()
    name = col[1].string.strip()
    link = col[1].find('a')
    if link:
        records[code] = {}
        records[code]['name'] = name
        records[code]['link'] = link.attrs['href']
        records[code]['classes'] = []


for key, value in records.items():
    cur_link = 'https://matriculaweb.unb.br/graduacao/' + value['link']

    count_codes = cursor.execute("SELECT count(*) from disciplina WHERE codigo = %s", (key))
    count_codes = cursor.fetchone()

    if count_codes[0] == 0:
        cursor.execute("INSERT IGNORE INTO disciplina(codigo, nome) VALUES (%s, %s);", (key, value['name']))

    page = requests.get(cur_link)
    soup = BeautifulSoup(page.text, 'html.parser')

    # TEACHERS
    teacherName = soup.find_all("td", {"valign": "middle", "class": "padraomenor", "bgcolor": "whitesmoke"})
    teachers = []
    for teacher in teacherName:
        teachers.append(teacher.text[:-1])

    classes = []
    codeClass = soup.findAll("div", {"class": "titulo"})
    for code in codeClass:
        classes.append(code.text)

    times = [[]]
    colTime = soup.findAll("div", {"style": "border: white 1px solid;"})
    if colTime:
        prevID = None
        for time in colTime:
            if not prevID:
                prevID = time.attrs['id']
            if prevID[:7] != time.attrs['id'][:7]:
                times.append([])
            prevID = time.attrs['id']

            time_text = time.text.encode('ascii', 'ignore').decode('ascii')
            if time_text[:3].lower() == "seg":
                day = "Segunda"
                initial_time = time_text[7:12]
                end_time = time_text[12:17]
            elif time_text[:3].lower() == "ter":
                day = "Terca"
                initial_time = time_text[4:9]
                end_time = time_text[9:14]
            elif time_text[:3].lower() == "qua":
                day = "Quarta"
                initial_time = time_text[6:11]
                end_time = time_text[11:16]
            elif time_text[:3].lower() == "qui":
                day = "Quinta"
                initial_time = time_text[6:11]
                end_time = time_text[11:16]
            elif time_text[:3].lower() == "sex":
                day = "Sexta"
                initial_time = time_text[5:10]
                end_time = time_text[10:15]
            elif time_text[:3].lower() == "sab":
                day = "Sabado"
                initial_time = time_text[6:11]
                end_time = time_text[11:16]
            elif time_text[:3].lower() == "dom":
                day = "Domingo"
                initial_time = time_text[7:12]
                end_time = time_text[12:17]

            times[-1].append({'day': day, 'initial_time': initial_time, 'end_time': end_time})

        locations = []
        colLocation = soup.findAll('i')
        for location in colLocation:
            locations.append(location.text[1:])

        print(locations)


    for i in range(len(classes)):
        value['classes'].append({'teacher': teachers[i], 'class': classes[i], 'times': times[i], 'location': locations[i]})

    for new_class in value['classes']:
        count_teachers = cursor.execute("SELECT count(*) FROM professor WHERE nome = %s", (new_class['teacher']))
        count_teachers = cursor.fetchone()

        if count_teachers[0] == 0:
            cursor.execute("INSERT IGNORE INTO professor(nome) VALUES ('" + new_class['teacher'] + "');")

        count_classes = cursor.execute("SELECT count(*) FROM turma WHERE disciplina = %s AND turma = %s", (key, new_class['class']))
        count_classes = cursor.fetchone()

        if count_classes[0] == 0:
            cur_teacher = cursor.execute("SELECT idprofessor FROM professor WHERE nome = %s", (new_class['teacher']))
            cur_teacher = cursor.fetchone()
            cursor.execute("INSERT IGNORE INTO turma(disciplina, professor, turma, local) VALUES (%s, %s, %s, %s);", (key, cur_teacher[0], new_class['class'], new_class['location']))

        cur_class = cursor.execute("SELECT turma_pk FROM turma WHERE disciplina = %s AND turma = %s", (key, new_class['class']))
        cur_class = cursor.fetchone()[0]

        count_times = cursor.execute("SELECT count(*) FROM horario WHERE turma_fk = %s", (cur_class))
        count_times = cursor.fetchone()

        if count_times[0] == 0:
            for new_times in  new_class['times']:
                if new_times['day'] == 'Domingo':
                    new_times['day'] = 'S'
                elif new_times['day'] == 'Segunda':
                    new_times['day'] = 'M'
                elif new_times['day'] == 'Terca':
                    new_times['day'] = 'T'
                elif new_times['day'] == 'Quarta':
                    new_times['day'] = 'W'
                elif new_times['day'] == 'Quinta':
                    new_times['day'] = 'R'
                elif new_times['day'] == 'Sexta':
                    new_times['day'] = 'F'
                elif new_times['day'] == 'Sabado':
                    new_times['day'] = 'U'

                cursor.execute("INSERT INTO horario(turma_fk, dia, hora_inicio, hora_fim) VALUES (%s, %s, %s, %s);", (cur_class, new_times['day'], new_times['initial_time'], new_times['end_time']))

                print(cur_class)
                print(new_times['day'])
                print(new_times['initial_time'])
                print(new_times['end_time'])

    print('==========> ' + value['name'] + ' OK!')

    input("Press Enter to continue...")

db.close()
