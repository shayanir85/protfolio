<template>
  <q-page class="portfolio-page">

    <!-- Hero Section -->
    <section id="hero" class="hero-section">
      <div class="hero-content">
        <div class="text-h2 text-weight-bold text-white">Hi, I'm Shayan</div>
        <div class="text-h5 text-blue-3 q-mt-sm">Backend Developer</div>
        <div class="text-body1 text-grey-4 q-mt-md hero-desc">
          20-year-old engineering student building scalable web applications with Laravel & PHP
        </div>
        <div class="q-mt-lg">
          <q-btn color="primary" label="View My Work" no-caps rounded href="#projects" class="q-mr-sm" />
          <q-btn outline color="white" label="Contact Me" no-caps rounded href="#contact" />
        </div>
      </div>
    </section>

    <!-- About Me Section -->
    <section id="about" class="section q-pa-xl">
      <div class="section-container">
        <div class="text-h4 text-weight-bold text-primary section-title">About Me</div>
        <q-separator color="primary" class="q-mb-xl" style="max-width: 80px; height: 3px;" />

        <div class="row q-gutter-xl items-start">
          <div class="col-12 col-md-7">
            <p class="text-body1 text-grey-8 leading-relaxed">
              Hi, I'm Shayan, a 20-year-old engineering student and backend developer in training.
              I started out in computer networking and software at technical high school, and I'm now
              building my career in backend web development with PHP and Laravel.
            </p>
            <p class="text-body1 text-grey-8 leading-relaxed q-mt-md">
              I focus on Laravel, PHP, MySQL, and JavaScript, with a clear goal of becoming a
              mid-level Laravel backend developer within the next 2 years through self-teaching,
              hands-on projects, and continuous learning.
            </p>
            <div class="q-mt-lg">
              <div class="text-h6 text-weight-medium q-mb-sm">Languages Spoken</div>
              <div class="q-gutter-sm">
                <q-badge v-for="lang in languages" :key="lang" color="primary" :label="lang" rounded />
              </div>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <q-card flat bordered class="about-card">
              <q-card-section>
                <div class="text-h6 text-weight-bold q-mb-md">Quick Info</div>
                <div class="q-gutter-y-sm">
                  <div class="row items-center q-gutter-sm">
                    <q-icon name="person" color="primary" size="sm" />
                    <span class="text-body2">Shayan Iranpour</span>
                  </div>
                  <div class="row items-center q-gutter-sm">
                    <q-icon name="cake" color="primary" size="sm" />
                    <span class="text-body2">20 years old</span>
                  </div>
                  <div class="row items-center q-gutter-sm">
                    <q-icon name="school" color="primary" size="sm" />
                    <span class="text-body2">Engineering Student</span>
                  </div>
                  <div class="row items-center q-gutter-sm">
                    <q-icon name="code" color="primary" size="sm" />
                    <span class="text-body2">Backend Developer</span>
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>
      </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="section q-pa-xl bg-grey-1">
      <div class="section-container">
        <div class="text-h4 text-weight-bold text-primary section-title">Experience</div>
        <q-separator color="primary" class="q-mb-xl" style="max-width: 80px; height: 3px;" />

        <div class="row q-gutter-lg">
          <div v-for="exp in experiences" :key="exp.title" class="col-12 col-md-5">
            <q-card flat bordered class="experience-card full-height">
              <q-card-section>
                <div class="row items-center q-mb-sm">
                  <q-icon :name="exp.icon" color="primary" size="md" class="q-mr-sm" />
                  <div class="text-h6 text-weight-bold">{{ exp.title }}</div>
                </div>
                <div class="text-subtitle2 text-primary q-mb-sm">{{ exp.period }}</div>
                <div class="text-body2 text-grey-7 q-mb-sm">{{ exp.company }}</div>
                <q-separator class="q-my-sm" />
                <ul class="exp-list">
                  <li v-for="(duty, i) in exp.duties" :key="i" class="text-body2 text-grey-7">
                    {{ duty }}
                  </li>
                </ul>
              </q-card-section>
            </q-card>
          </div>
        </div>

        <!-- Tech Stack -->
        <div class="q-mt-xl">
          <div class="text-h5 text-weight-bold q-mb-md">Tech Stack</div>
          <div class="row q-gutter-sm">
            <q-badge v-for="tech in techStack" :key="tech" color="dark" :label="tech" rounded
              class="tech-badge" />
          </div>
        </div>

        <!-- Goals -->
        <div class="q-mt-xl">
          <q-card flat bordered class="goals-card">
            <q-card-section>
              <div class="row items-center q-mb-sm">
                <q-icon name="flag" color="primary" size="md" class="q-mr-sm" />
                <div class="text-h6 text-weight-bold">Goals</div>
              </div>
              <ul class="exp-list">
                <li class="text-body2 text-grey-7">Achieve mid-level Laravel backend developer</li>
                <li class="text-body2 text-grey-7">Build real-world projects to attract businesses and freelance opportunities</li>
                <li class="text-body2 text-grey-7">Share my journey and projects openly on GitHub & LinkedIn</li>
              </ul>
            </q-card-section>
          </q-card>
        </div>
      </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="section q-pa-xl">
      <div class="section-container">
        <div class="text-h4 text-weight-bold text-primary section-title">Projects</div>
        <q-separator color="primary" class="q-mb-xl" style="max-width: 80px; height: 3px;" />

        <!-- Loading State -->
        <div v-if="loadingProjects" class="row q-gutter-lg">
          <div v-for="n in 3" :key="n" class="col-12 col-md-4">
            <q-card flat bordered class="project-card full-height">
              <q-card-section>
                <q-skeleton type="circle" size="40px" class="q-mb-sm" />
                <q-skeleton type="text" width="60%" height="24px" />
                <q-separator class="q-my-sm" />
                <q-skeleton type="text" width="100%" />
                <q-skeleton type="text" width="80%" />
                <div class="q-mt-md">
                  <q-skeleton type="rect" width="60px" height="20px" class="q-mr-xs" />
                  <q-skeleton type="rect" width="50px" height="20px" />
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>

        <!-- Error State -->
        <q-banner v-else-if="projectsError" class="bg-red-1 text-red-8 q-mb-md" rounded>
          <template #avatar>
            <q-icon name="error" color="red" />
          </template>
          {{ projectsError }}
        </q-banner>

        <!-- Projects Grid -->
        <div v-else class="row q-gutter-lg">
          <div v-for="project in projects" :key="project.id" class="col-12 col-md-4">
            <q-card flat bordered class="project-card full-height">
              <q-card-section>
                <div class="row items-center q-mb-sm">
                  <q-icon name="folder" color="primary" size="lg" class="q-mr-sm" />
                  <div class="text-h6 text-weight-bold text-truncate">{{ project.full_name }}</div>
                </div>
                <q-separator class="q-my-sm" />
                <p class="text-body2 text-grey-7 project-desc">{{ project.description || 'No description provided.' }}</p>
                <div class="row items-center q-gutter-md q-mt-md text-caption text-grey-6">
                  <div class="row items-center q-gutter-xs">
                    <q-icon name="star" size="xs" />
                    <span>{{ project.stargazers_count }}</span>
                  </div>
                  <div class="row items-center q-gutter-xs">
                    <q-icon name="call_split" size="xs" />
                    <span>{{ project.forks_count }}</span>
                  </div>
                  <div class="row items-center q-gutter-xs">
                    <q-icon name="visibility" size="xs" />
                    <span>{{ project.watchers_count }}</span>
                  </div>
                </div>
              </q-card-section>
              <q-card-actions class="q-px-md q-pb-md">
                <q-btn flat color="primary" label="View on GitHub" no-caps icon="launch"
                  :href="project.html_url" target="_blank" />
              </q-card-actions>
            </q-card>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="!loadingProjects && !projectsError && projects.length === 0" class="text-center q-pa-xl">
          <q-icon name="inbox" size="64px" color="grey-4" />
          <div class="text-h6 text-grey-6 q-mt-md">No projects to display yet</div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section q-pa-xl bg-grey-1">
      <div class="section-container">
        <div class="text-h4 text-weight-bold text-primary section-title">Contact</div>
        <q-separator color="primary" class="q-mb-xl" style="max-width: 80px; height: 3px;" />

        <div class="row q-gutter-xl">
          <div class="col-12 col-md-6">
            <div class="text-h6 text-weight-medium q-mb-md">Get In Touch</div>
            <p class="text-body1 text-grey-7">
              I'm always open to discussing new projects, creative ideas, or opportunities
              to be part of your vision. Feel free to reach out!
            </p>
            <div class="q-mt-lg">
              <div class="row items-center q-gutter-sm q-mb-md">
                <q-icon name="email" color="primary" size="sm" />
                <span class="text-body1">shayaniranpor8@gmail.com</span>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-5">
            <q-card flat bordered>
              <q-card-section>
                <div class="text-h6 text-weight-bold q-mb-md">Connect With Me</div>
                <div class="q-gutter-md">
                  <q-btn outline color="primary" icon="fab fa-github" label="GitHub" no-caps
                    class="full-width" href="https://github.com/shayanir85" target="_blank" />
                  <q-btn outline color="blue-7" icon="fab fa-linkedin" label="LinkedIn" no-caps
                    class="full-width" href="https://www.linkedin.com/in/shayan-iranpor-090642332" target="_blank" />
                  <q-btn outline color="pink" icon="fab fa-instagram" label="Instagram" no-caps
                    class="full-width" href="https://www.instagram.com/shayan_iranpor" target="_blank" />
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center q-pa-md">
      <div class="text-body2">
        Built with Quasar &bull; &copy; {{ new Date().getFullYear() }} Shayan Iranpour
      </div>
    </footer>

  </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const API_BASE = 'http://127.0.0.1:8000/api'

const projects = ref([])
const loadingProjects = ref(true)
const projectsError = ref(null)

const languages = ['Persian', 'Turkish', 'English']

const experiences = [
  {
    title: 'Education',
    period: '2022 - Present',
    company: 'Engineering University',
    icon: 'school',
    duties: [
      'Computer Networking & Software background from technical high school',
      'Currently pursuing engineering degree',
      'Self-teaching backend development through online resources and practice',
    ],
  },
  {
    title: 'Backend Developer',
    period: '2023 - Present',
    company: 'Self-employed / Freelance',
    icon: 'code',
    duties: [
      'Developing web applications with Laravel and PHP',
      'Building RESTful APIs and database-driven solutions',
      'Working with MySQL, Git, and modern development workflows',
    ],
  },
]

const techStack = [
  'PHP', 'JavaScript', 'SQL', 'Laravel', 'MySQL',
  'Git', 'GitHub', 'HTML5', 'CSS3', 'Bootstrap',
  'jQuery', 'Vue.js', 'Apache', 'Nginx',
  'Adobe Photoshop', 'Adobe Illustrator', 'Adobe After Effects', 'Adobe Premiere Pro',
]

async function fetchProjects() {
  loadingProjects.value = true
  projectsError.value = null
  try {
    const res = await fetch(`${API_BASE}/proj`)
    if (!res.ok) throw new Error(`HTTP ${res.status}`)
    const json = await res.json()
    projects.value = json.data ?? json
  } catch (err) {
    projectsError.value = 'Failed to load projects. Make sure the backend is running.'
    console.error('Failed to fetch projects:', err)
  } finally {
    loadingProjects.value = false
  }
}

onMounted(() => {
  fetchProjects()
})
</script>

<style scoped>
.portfolio-page {
  font-family: 'Roboto', sans-serif;
}

/* Hero */
.hero-section {
  background: linear-gradient(135deg, #1a237e 0%, #0d47a1 50%, #01579b 100%);
  min-height: 70vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 60px 20px;
}

.hero-content {
  max-width: 700px;
}

.hero-desc {
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
}

/* Sections */
.section {
  padding-top: 60px;
  padding-bottom: 60px;
}

.section-container {
  max-width: 1100px;
  margin: 0 auto;
}

.section-title {
  position: relative;
  display: inline-block;
}

/* About Card */
.about-card {
  border-radius: 12px;
}

/* Experience */
.experience-card {
  border-radius: 12px;
  transition: transform 0.2s, box-shadow 0.2s;
}

.experience-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.exp-list {
  padding-left: 20px;
  margin: 0;
}

.exp-list li {
  margin-bottom: 6px;
}

.tech-badge {
  font-size: 0.85rem;
  padding: 6px 14px;
}

/* Goals */
.goals-card {
  border-radius: 12px;
  border-left: 4px solid #1976d2;
}

/* Projects */
.project-card {
  border-radius: 12px;
  transition: transform 0.2s, box-shadow 0.2s;
}

.project-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.project-desc {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  min-height: 3.6em;
}

/* Smooth scroll */
html {
  scroll-behavior: smooth;
}
</style>
