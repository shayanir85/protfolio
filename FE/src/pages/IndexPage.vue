<template>
  <q-page class="portfolio-page">
    <!-- Scroll Progress Bar -->
    <div class="scroll-progress-bar" :style="{ width: scrollProgress + '%' }"></div>
    <!-- Floating Navbar -->
    <q-toolbar class="navbar" :class="{ scrolled: isScrolled }">
      <div class="navbar-container">
        <div class="logo" @click="scrollTo('hero')">
          <div class="logo-mark">S</div>
          <span class="logo-text">Shayan</span>
        </div>

        <nav class="nav-links">
          <a
            v-for="link in navLinks"
            :key="link.id"
            :href="`#${link.id}`"
            :class="{ active: activeSection === link.id }"
            @click.prevent="scrollTo(link.id)"
          >
            {{ link.label }}
          </a>
        </nav>

        <div class="nav-actions">
          <q-btn
            round
            flat
            dense
            :icon="isDark ? 'wb_sunny' : 'nights_stay'"
            @click="toggleDark"
            class="theme-toggle"
            :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
          >
            <q-tooltip anchor="bottom middle" self="top middle" :offset="[0, 10]">
              {{ isDark ? 'Light Mode' : 'Dark Mode' }}
            </q-tooltip>
          </q-btn>
          <q-btn
            color="primary"
            label="Hire Me"
            no-caps
            rounded
            unelevated
            @click="scrollTo('contact')"
            class="hire-btn"
          />
        </div>

        <q-btn
          flat
          round
          dense
          icon="menu"
          class="mobile-menu-btn"
          @click="mobileMenuOpen = true"
        />
      </div>
    </q-toolbar>

    <!-- Mobile Menu -->
    <q-dialog v-model="mobileMenuOpen" position="right" full-height>
      <q-card class="mobile-menu">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Menu</div>
          <q-space />
          <q-btn icon="close" flat round dense @click="mobileMenuOpen = false" />
        </q-card-section>
        <q-card-section>
          <q-list>
            <q-item
              v-for="link in navLinks"
              :key="link.id"
              clickable
              v-close-popup
              @click="scrollTo(link.id)"
            >
              <q-item-section>{{ link.label }}</q-item-section>
            </q-item>
          </q-list>
        </q-card-section>
      </q-card>
    </q-dialog>

    <!-- HERO SECTION -->
    <section id="hero" class="hero-section">
      <div class="hero-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
        <div class="grid-overlay"></div>
      </div>

      <div class="hero-content" data-animate>
        <q-chip
          class="hero-chip"
          color="primary"
          text-color="white"
          icon="auto_awesome"
          outline
          dense
        >
          Available for opportunities
        </q-chip>

        <h1 class="hero-title">
          Hi, I'm <span class="gradient-text">Shayan</span>
        </h1>

        <div class="typewriter-container">
          <span class="typewriter-prefix">I'm a </span>
          <span class="typewriter-text">{{ displayedText }}</span>
          <span class="typewriter-cursor">|</span>
        </div>

        <p class="hero-description">
          A 20-year-old engineering student crafting scalable web applications with
          <strong>Laravel & PHP</strong>. Passionate about clean code, elegant APIs,
          and solving real-world problems.
        </p>

        <div class="hero-actions">
          <q-btn
            color="primary"
            label="View My Work"
            no-caps
            rounded
            unelevated
            icon-right="arrow_forward"
            @click="scrollTo('projects')"
            size="lg"
            class="btn-primary-grad"
          />
          <q-btn
            outline
            color="primary"
            label="Get in Touch"
            no-caps
            rounded
            size="lg"
            icon="mail"
            @click="scrollTo('contact')"
          />
        </div>

        <div class="stats-row">
          <div
            v-for="(stat, idx) in stats"
            :key="idx"
            class="stat-card glass-card"
            :style="{ animationDelay: idx * 0.1 + 's' }"
          >
            <div class="stat-value">
              <span class="stat-number">{{ stat.animated }}</span>
              <span class="stat-suffix">{{ stat.suffix }}</span>
            </div>
            <div class="stat-label">{{ stat.label }}</div>
          </div>
        </div>
      </div>

      <div class="scroll-indicator" @click="scrollTo('about')">
        <span>Scroll to explore</span>
        <div class="scroll-mouse">
          <div class="scroll-dot"></div>
        </div>
      </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="section" data-animate>
      <div class="section-container">
        <div class="section-header">
          <span class="section-subtitle">Get to know me</span>
          <h2 class="section-title">About Me</h2>
          <div class="section-divider"></div>
        </div>

        <div class="about-grid">
          <div class="about-image-col">
            <div class="avatar-wrapper">
              <div class="avatar-ring">
                <div class="avatar-inner">
                  <q-icon name="person" size="120px" color="primary" />
                </div>
              </div>
              <div class="avatar-badge">
                <q-icon name="verified" color="primary" size="24px" />
              </div>
              <div class="orbit orbit-1"></div>
              <div class="orbit orbit-2"></div>
            </div>
          </div>

          <div class="about-text-col">
            <h3 class="about-heading">
              Backend Developer &amp; Engineering Student
            </h3>
            <p class="about-paragraph">
              I'm Shayan, a passionate backend developer focused on building robust,
              scalable web applications. Starting from a foundation in computer networking
              and software at technical high school, I've dedicated myself to mastering
              <strong>PHP, Laravel, and MySQL</strong>.
            </p>
            <p class="about-paragraph">
              My goal is to become a mid-level Laravel backend developer within the next
              two years through self-teaching, real-world projects, and continuous learning.
              I believe in writing clean, maintainable code that stands the test of time.
            </p>

            <div class="info-grid">
              <div class="info-item">
                <q-icon name="person" color="primary" />
                <div>
                  <div class="info-label">Name</div>
                  <div class="info-value">Shayan Iranpour</div>
                </div>
              </div>
              <div class="info-item">
                <q-icon name="cake" color="primary" />
                <div>
                  <div class="info-label">Age</div>
                  <div class="info-value">20 years old</div>
                </div>
              </div>
              <div class="info-item">
                <q-icon name="school" color="primary" />
                <div>
                  <div class="info-label">Education</div>
                  <div class="info-value">Engineering Student</div>
                </div>
              </div>
              <div class="info-item">
                <q-icon name="location_on" color="primary" />
                <div>
                  <div class="info-label">Focus</div>
                  <div class="info-value">Backend Development</div>
                </div>
              </div>
            </div>

            <div class="languages-section">
              <div class="info-label q-mb-sm">Languages Spoken</div>
              <div class="q-gutter-sm">
                <q-chip
                  v-for="lang in languages"
                  :key="lang"
                  color="primary"
                  text-color="white"
                  :label="lang"
                  icon="translate"
                  outline
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SKILLS SECTION -->
    <section id="skills" class="section section-alt" data-animate>
      <div class="section-container">
        <div class="section-header">
          <span class="section-subtitle">What I work with</span>
          <h2 class="section-title">Tech Stack</h2>
          <div class="section-divider"></div>
        </div>

        <div class="skill-tabs">
          <q-btn-toggle
            v-model="activeSkillCategory"
            toggle-color="primary"
            no-caps
            rounded
            unelevated
            :options="skillCategories.map(cat => ({ label: cat.name, value: cat.name }))"
            class="skill-toggle"
          />
        </div>

        <transition-group name="skill-fade" tag="div" class="skills-grid">
          <div
            v-for="tech in currentSkills"
            :key="tech"
            class="skill-card glass-card"
          >
            <div class="skill-icon-wrapper">
              <q-icon :name="getSkillIcon(tech)" size="32px" color="primary" />
            </div>
            <div class="skill-name">{{ tech }}</div>
            <q-linear-progress
              :value="getSkillLevel(tech) / 100"
              color="primary"
              track-color="grey-3"
              rounded
              size="6px"
              class="skill-bar"
            />
          </div>
        </transition-group>

        <!-- Progress Bars -->
        <div class="skill-bars-wrapper">
          <h3 class="text-h5 text-weight-bold q-mb-lg text-center">
            Proficiency Levels
          </h3>
          <div class="progress-bars">
            <div v-for="skill in skills" :key="skill.name" class="progress-item">
              <div class="progress-header">
                <span class="progress-label">{{ skill.name }}</span>
                <span class="progress-value">{{ skill.level }}%</span>
              </div>
              <div class="progress-track">
                <div
                  class="progress-fill"
                  :style="{ width: animatedSkillBars ? skill.level + '%' : '0%' }"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- EXPERIENCE TIMELINE -->
    <section id="experience" class="section" data-animate>
      <div class="section-container">
        <div class="section-header">
          <span class="section-subtitle">My journey so far</span>
          <h2 class="section-title">Experience</h2>
          <div class="section-divider"></div>
        </div>

        <div class="timeline">
          <div
            v-for="(exp, idx) in experiences"
            :key="exp.title"
            class="timeline-item"
            :class="idx % 2 === 0 ? 'left' : 'right'"
            :style="{ animationDelay: idx * 0.2 + 's' }"
          >
            <div class="timeline-marker">
              <q-icon :name="exp.icon" color="white" size="20px" />
            </div>
            <div class="timeline-content glass-card">
              <div class="timeline-period">{{ exp.period }}</div>
              <h3 class="timeline-title">{{ exp.title }}</h3>
              <div class="timeline-company">
                <q-icon name="business" size="xs" class="q-mr-xs" />
                {{ exp.company }}
              </div>
              <q-separator class="q-my-md" />
              <ul class="timeline-duties">
                <li v-for="(duty, i) in exp.duties" :key="i">
                  {{ duty }}
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Goals -->
        <div class="goals-wrapper">
          <q-card flat bordered class="goals-card glass-card">
            <q-card-section>
              <div class="goals-header">
                <div class="goals-icon">
                  <q-icon name="flag" color="primary" size="28px" />
                </div>
                <h3 class="goals-title">My Goals</h3>
              </div>
              <div class="goals-grid">
                <div v-for="(goal, i) in goals" :key="i" class="goal-item">
                  <q-icon :name="goal.icon" color="primary" size="24px" />
                  <div class="goal-text">{{ goal.text }}</div>
                </div>
              </div>
            </q-card-section>
          </q-card>
        </div>
      </div>
    </section>

    <!-- PROJECTS SECTION -->
    <section id="projects" class="section section-alt" data-animate>
      <div class="section-container">
        <div class="section-header">
          <span class="section-subtitle">My recent work</span>
          <h2 class="section-title">Projects</h2>
          <div class="section-divider"></div>
        </div>


        <!-- Loading Skeleton with shimmer -->
        <div v-if="loadingProjects" class="projects-grid">
          <div v-for="n in 6" :key="n" class="project-card-wrapper">
            <q-card flat bordered class="project-card glass-card">
              <q-card-section>
                <div class="shimmer-row">
                  <div class="shimmer-circle shimmer"></div>
                  <div class="shimmer-lines">
                    <div class="shimmer-line shimmer w-60"></div>
                    <div class="shimmer-line shimmer w-40"></div>
                  </div>
                </div>
                <q-separator class="q-my-md" />
                <div class="shimmer-line shimmer w-100 q-mb-sm"></div>
                <div class="shimmer-line shimmer w-80 q-mb-sm"></div>
                <div class="shimmer-line shimmer w-90"></div>
                <div class="shimmer-tags q-mt-md">
                  <div class="shimmer-tag shimmer"></div>
                  <div class="shimmer-tag shimmer"></div>
                  <div class="shimmer-tag shimmer"></div>
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>

        <!-- Error State -->
        <div v-else-if="projectsError" class="empty-state">
          <div class="empty-icon error">
            <q-icon name="error_outline" size="64px" />
          </div>
          <h3 class="empty-title">Something went wrong</h3>
          <p class="empty-text">{{ projectsError }}</p>
          <q-btn
            color="primary"
            label="Try Again"
            no-caps
            rounded
            icon="refresh"
            @click="fetchProjects"
          />
        </div>

        <!-- Empty State -->
        <div
          v-else-if="filteredProjects.length === 0"
          class="empty-state"
        >
          <div class="empty-icon">
            <q-icon name="inventory_2" size="64px" />
          </div>
          <h3 class="empty-title">No projects yet</h3>
          <p class="empty-text">
            {{
              activeFilter === 'all'
                ? 'New projects are on the way! Stay tuned.'
                : 'No projects match this filter.'
            }}
          </p>
        </div>

        <!-- Projects Grid -->
        <div v-else class="projects-grid">
          <div
            v-for="(project, idx) in filteredProjects"
            :key="project.id"
            class="project-card-wrapper"
            :style="{ animationDelay: idx * 0.1 + 's' }"
          >
            <q-card flat bordered class="project-card glass-card">
              <div class="project-header-gradient"></div>
              <q-card-section class="project-body">
                <div class="project-icon">
                  <q-icon name="folder" color="white" size="28px" />
                </div>
                <h3 class="project-name">{{ project.full_name }}</h3>
                <p class="project-desc">
                  {{ project.description || 'No description provided.' }}
                </p>

                <div class="project-meta">
                  <div class="meta-item">
                    <q-icon name="star" color="amber" size="xs" />
                    <span>{{ project.stargazers_count }}</span>
                  </div>
                  <div class="meta-item">
                    <q-icon name="call_split" color="primary" size="xs" />
                    <span>{{ project.forks_count }}</span>
                  </div>
                  <div class="meta-item">
                    <q-icon name="visibility" color="grey-7" size="xs" />
                    <span>{{ project.watchers_count }}</span>
                  </div>
                </div>
              </q-card-section>

              <q-card-actions class="project-actions">
                <q-btn
                  flat
                  color="primary"
                  label="View on GitHub"
                  no-caps
                  icon-right="open_in_new"
                  :href="project.html_url"
                  target="_blank"
                  class="full-width"
                />
              </q-card-actions>
            </q-card>
          </div>
        </div>
      </div>
    </section>

    <!-- CONTACT SECTION -->
    <section id="contact" class="section" data-animate>
      <div class="section-container">
        <div class="section-header">
          <span class="section-subtitle">Let's work together</span>
          <h2 class="section-title">Get In Touch</h2>
          <div class="section-divider"></div>
        </div>

        <div class="contact-grid">
          <div class="contact-info-col">
            <h3 class="contact-heading">
              Have a project in mind? <br />
              <span class="gradient-text">Let's talk!</span>
            </h3>
            <p class="contact-text">
              I'm always open to discussing new projects, creative ideas, or
              opportunities to be part of your vision. Whether it's a freelance gig,
              collaboration, or just a chat about code — feel free to reach out.
            </p>

            <div class="contact-methods">
              <a :href="`mailto:${userEmail}`" class="contact-method glass-card">
                <div class="contact-method-icon email">
                  <q-icon name="email" size="24px" />
                </div>
                <div>
                  <div class="contact-method-label">Email</div>
                  <div class="contact-method-value">{{ userEmail }}</div>
                </div>
              </a>

              <template v-if="socialLinks.length > 0">
                <a
                  v-for="(link, index) in socialLinks"
                  :key="index"
                  :href="link.social_link"
                  target="_blank"
                  class="contact-method glass-card"
                >
                  <div :class="`contact-method-icon ${link.social_media_name}`">
                    <q-icon :name="getSocialIcon(link.social_media_name)" size="24px" />
                  </div>
                  <div>
                    <div class="contact-method-label">{{ link.social_media_name }}</div>
                    <div class="contact-method-value">
                      {{ link.social_link.replace('https://', '').replace('www.', '') }}
                    </div>
                  </div>
                </a>
              </template>
            </div>
          </div>

          <div class="contact-form-col">
            <q-card flat bordered class="contact-form-card glass-card">
              <q-card-section>
                <h3 class="form-title">Send me a message</h3>
                <q-form @submit="onContactSubmit" class="q-gutter-md">
                  <q-input
                    v-model="contactForm.name"
                    label="Your Name"
                    outlined
                    dense
                    :rules="[v => !!v || 'Name is required']"
                  >
                    <template #prepend>
                      <q-icon name="person" color="grey-7" />
                    </template>
                  </q-input>
                  <q-input
                    v-model="contactForm.email"
                    label="Your Email"
                    type="email"
                    outlined
                    dense
                    :rules="[v => !!v || 'Email is required']"
                  >
                    <template #prepend>
                      <q-icon name="email" color="grey-7" />
                    </template>
                  </q-input>
                  <q-input
                    v-model="contactForm.message"
                    label="Your Message"
                    type="textarea"
                    outlined
                    rows="4"
                    :rules="[v => !!v || 'Message is required']"
                  >
                    <template #prepend>
                      <q-icon name="message" color="grey-7" />
                    </template>
                  </q-input>
                  <q-btn
                    type="submit"
                    color="primary"
                    label="Send Message"
                    no-caps
                    rounded
                    unelevated
                    icon-right="send"
                    size="lg"
                    class="full-width btn-primary-grad"
                  />
                </q-form>
              </q-card-section>
            </q-card>
          </div>
        </div>
      </div>
    </section>

    <!-- FOOTER -->
    <footer class="site-footer">
      <div class="footer-container">
        <div class="footer-top">
          <div class="footer-brand">
            <div class="logo" @click="scrollTo('hero')">
              <div class="logo-mark">S</div>
              <span class="logo-text">Shayan</span>
            </div>
            <p class="footer-tagline">
              Building the web, one endpoint at a time.
            </p>
          </div>

          <div class="footer-socials" v-if="socialLinks.length > 0">
            <q-btn
              v-for="(link, index) in socialLinks"
              :key="index"
              round
              flat
              :icon="getSocialIcon(link.social_media_name)"
              :href="link.social_link"
              target="_blank"
            />
          </div>
        </div>

        <q-separator class="footer-separator" />

        <div class="footer-bottom">
          <div class="text-body2">
            Built with <span class="gradient-text">Quasar & Vue</span> •
            © {{ new Date().getFullYear() }} Shayan Iranpour. All rights reserved.
          </div>
        </div>
      </div>
    </footer>
  </q-page>
</template>

<script setup>
import { ref, reactive, computed, onMounted, onUnmounted, nextTick, watch } from 'vue'
import { useQuasar } from 'quasar'

const $q = useQuasar()
const API_BASE = 'http://127.0.0.1:8000/api'

// ============ STATE ============
const projects = ref([])
const loadingProjects = ref(true)
const projectsError = ref(null)

const socialLinks = ref([])
const loadingSocials = ref(false)

const userEmail = ref('shayaniranpor84@gmail.com')

const activeSection = ref('hero')
const scrollProgress = ref(0)
const isScrolled = ref(false)
const mobileMenuOpen = ref(false)
const activeFilter = ref('all')
const activeSkillCategory = ref('Backend')
const animatedSkillBars = ref(false)

// Dark mode
const isDark = ref(false)

// Typewriter
const typewriterTexts = [
  'Backend Developer',
  'Laravel Enthusiast',
  'computer Engineer',
  'Problem Solver',
  'Code Craftsman',
]
const currentTextIndex = ref(0)
const displayedText = ref('')
let typewriterTimeout = null

// Navigation
const navLinks = [
  { id: 'about', label: 'About' },
  { id: 'skills', label: 'Skills' },
  { id: 'experience', label: 'Experience' },
  { id: 'projects', label: 'Projects' },
  { id: 'contact', label: 'Contact' },
]

// Stats with animated counters
const stats = reactive([
  { value: 2, label: 'Years Learning', suffix: '+', animated: 0 },
  { value: 0, label: 'Projects Built', suffix: '+', animated: 0 },
  { value: 3, label: 'Languages', suffix: '', animated: 0 },
])

// Data
const languages = ['Persian', 'Turkish', 'English']

const experiences = [
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
  {
    title: 'Engineering Student',
    period: '2022 - Present',
    company: 'Engineering University',
    icon: 'school',
    duties: [
      'Computer Networking & Software background from technical high school',
      'Currently pursuing engineering degree',
      'Self-teaching backend development through online resources',
    ],
  },
]

const goals = [
  {
    icon: 'emoji_events',
    text: 'Achieve mid-level Laravel backend developer status',
  },
  {
    icon: 'rocket_launch',
    text: 'Build real-world projects to attract freelance opportunities',
  },
  {
    icon: 'share',
    text: 'Share my journey and projects openly on GitHub & LinkedIn',
  },
  {
    icon: 'groups',
    text: 'Contribute to open-source Laravel projects',
  },
]

const skillCategories = [
  { name: 'Backend', items: ['PHP', 'Laravel', 'MySQL', 'SQL', 'REST APIs'] },
  {
    name: 'Frontend',
    items: ['JavaScript', 'Vue.js', 'HTML5', 'CSS3', 'Bootstrap', 'jQuery'],
  },
  { name: 'DevOps', items: ['Git', 'GitHub', 'Apache', 'Nginx', 'Linux'] },
  {
    name: 'Design',
    items: ['Photoshop', 'Illustrator', 'After Effects', 'Premiere Pro'],
  },
]

const skills = [
  { name: 'PHP', level: 85 },
  { name: 'Laravel', level: 75 },
  { name: 'MySQL', level: 80 },
  { name: 'JavaScript', level: 70 },
  { name: 'Vue.js', level: 65 },
  { name: 'Git', level: 75 },
]


const contactForm = reactive({
  name: '',
  email: '',
  message: '',
})

// ============ COMPUTED ============
const currentSkills = computed(() => {
  const cat = skillCategories.find((c) => c.name === activeSkillCategory.value)
  return cat ? cat.items : []
})

const filteredProjects = computed(() => {
  if (activeFilter.value === 'all') return projects.value
  return projects.value.filter((p) => {
    const name = (p.full_name || '').toLowerCase()
    const desc = (p.description || '').toLowerCase()
    const lang = (p.language || '').toLowerCase()
    const filter = activeFilter.value.toLowerCase()
    return (
      name.includes(filter) || desc.includes(filter) || lang.includes(filter)
    )
  })
})

// ============ METHODS ============
function toggleDark() {
  isDark.value = !isDark.value
  $q.dark.set(isDark.value)
  localStorage.setItem('darkMode', isDark.value.toString())
}

function scrollTo(id) {
  const el = document.getElementById(id)
  if (el) {
    el.scrollIntoView({ behavior: 'smooth', block: 'start' })
    mobileMenuOpen.value = false
  }
}

function handleScroll() {
  const scrollTop = window.scrollY
  const docHeight = document.documentElement.scrollHeight - window.innerHeight
  scrollProgress.value = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0
  isScrolled.value = scrollTop > 50

  // Update active section
  const sections = navLinks.map((l) => l.id).concat(['hero'])
  for (const id of sections) {
    const el = document.getElementById(id)
    if (!el) continue
    const rect = el.getBoundingClientRect()
    if (rect.top <= 150 && rect.bottom >= 150) {
      activeSection.value = id
      break
    }
  }
}

// Typewriter effect
function typeWriter(text, i, cb) {
  if (i < text.length) {
    displayedText.value += text.charAt(i)
    typewriterTimeout = setTimeout(() => typeWriter(text, i + 1, cb), 80)
  } else if (cb) {
    typewriterTimeout = setTimeout(cb, 2000)
  }
}

function deleteText(cb) {
  if (displayedText.value.length > 0) {
    displayedText.value = displayedText.value.slice(0, -1)
    typewriterTimeout = setTimeout(() => deleteText(cb), 40)
  } else if (cb) {
    typewriterTimeout = setTimeout(cb, 500)
  }
}

function startTypewriter() {
  const text = typewriterTexts[currentTextIndex.value]
  typeWriter(text, 0, () => {
    deleteText(() => {
      currentTextIndex.value = (currentTextIndex.value + 1) % typewriterTexts.length
      startTypewriter()
    })
  })
}

// Counter animation
function animateCounters() {
  stats.forEach((stat) => {
    let current = 0
    const duration = 2000
    const stepTime = 30
    const steps = duration / stepTime
    const increment = stat.value / steps
    const interval = setInterval(() => {
      current += increment
      if (current >= stat.value) {
        stat.animated = stat.value
        clearInterval(interval)
      } else {
        stat.animated = Math.floor(current)
      }
    }, stepTime)
  })
}

// Skill icons helper
function getSkillIcon(tech) {
  const icons = {
    PHP: 'code',
    Laravel: 'extension',
    MySQL: 'storage',
    SQL: 'storage',
    JavaScript: 'javascript',
    'Vue.js': 'web',
    HTML5: 'html',
    CSS3: 'css',
    Bootstrap: 'palette',
    jQuery: 'code',
    Git: 'call_split',
    GitHub: 'fab fa-github',
    Apache: 'dns',
    Nginx: 'dns',
    Linux: 'computer',
    'REST APIs': 'api',
    Photoshop: 'image',
    Illustrator: 'brush',
    'After Effects': 'movie',
    'Premiere Pro': 'videocam',
  }
  return icons[tech] || 'memory'
}

function getSocialIcon(platform) {
  const icons = {
    github: 'fab fa-github',
    linkedin: 'fab fa-linkedin',
    instagram: 'fab fa-instagram',
    twitter: 'fab fa-twitter',
    facebook: 'fab fa-facebook',
    youtube: 'fab fa-youtube',
    telegram: 'fab fa-telegram',
    whatsapp: 'fab fa-whatsapp',
    email: 'email',
    website: 'language',
  }
  const platformLower = (platform || '').toLowerCase()
  return icons[platformLower] || 'link'
}

function getSkillLevel(tech) {
  const levels = {
    PHP: 85,
    Laravel: 80,
    MySQL: 80,
    SQL: 75,
    JavaScript: 70,
    'Vue.js': 65,
    HTML5: 85,
    CSS3: 80,
    Bootstrap: 85,
    jQuery: 70,
    Git: 75,
    GitHub: 80,
    Apache: 70,
    Nginx: 65,
    Linux: 70,
    'REST APIs': 85,
    Photoshop: 60,
    Illustrator: 55,
    'After Effects': 45,
    'Premiere Pro': 50,
  }
  return levels[tech] || 70
}

function setupScrollAnimations() {
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate-in')
          if (entry.target.id === 'skills') {
            animatedSkillBars.value = true
          }
        }
      })
    },
    { threshold: 0.15, rootMargin: '0px 0px -50px 0px' }
  )

  nextTick(() => {
    document.querySelectorAll('[data-animate]').forEach((el) => observer.observe(el))
  })
}

function setupStatsObserver() {
  let animated = false
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && !animated) {
          animated = true
          animateCounters()
        }
      })
    },
    { threshold: 0.5 }
  )

  nextTick(() => {
    const statsEl = document.querySelector('.stats-row')
    if (statsEl) observer.observe(statsEl)
  })
}

function onContactSubmit() {
  $q.notify({
    type: 'positive',
    message: 'Thanks for reaching out! I will get back to you soon.',
    icon: 'check_circle',
    position: 'top',
  })
  contactForm.name = ''
  contactForm.email = ''
  contactForm.message = ''
}

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

async function fetchProjectsCount() {
  loadingProjects.value = true
  projectsError.value = null
  try {
    const res = await fetch(`${API_BASE}/proj/count`)
    if (!res.ok) throw new Error(`HTTP ${res.status}`)
    const json = await res.json()
    const count = json.count ?? json.data ?? json
    stats[1].value = typeof count === 'number' ? count : 0
    animateCounters()
    return stats[1].value
  } catch (err) {
    projectsError.value = 'Failed to load project count. Make sure the backend is running.'
    console.error('Failed to fetch project count:', err)
    
    $q.notify({
      type: 'negative',
      message: 'Could not load project count. Please try again later.',
      position: 'top',
    })
  } finally {
    loadingProjects.value = false
  }
}

async function fetchSocials() {
  loadingSocials.value = true
  
  try {
    const res = await fetch(`${API_BASE}/user/socials`)
    if (!res.ok) throw new Error(`HTTP ${res.status}`)
    
    const data = await res.json()
    
    
    if (Array.isArray(data)) {
      socialLinks.value = data
    } 
    else if (data.data && Array.isArray(data.data)) {
      socialLinks.value = data.data
    }
    else if (typeof data === 'object' && data !== null) {
      const arrayData = Object.values(data)
      if (arrayData.every(item => typeof item === 'object')) {
        socialLinks.value = arrayData
      }
    }
    
    localStorage.setItem('social_links', JSON.stringify({
      data: socialLinks.value,
      timestamp: Date.now()
    }))
    
  } catch (err) {
    console.error('Failed to fetch social links:', err)
  } finally {
    loadingSocials.value = false
  }
}

async function fetchEmail() {
  try {
    const res = await fetch(`${API_BASE}/user/email`)
    if (!res.ok) throw new Error(`HTTP ${res.status}`)
    const json = await res.json()
    if (json.email) {
      userEmail.value = json.email
    }
  } catch (err) {
    console.error('Failed to fetch user email:', err)
  }
}

// ============ LIFECYCLE ============
onMounted(() => {
  // Dark mode init
  const savedDark = localStorage.getItem('darkMode')
  if (savedDark !== null) {
    isDark.value = savedDark === 'true'
  } else {
    isDark.value = $q.dark.isActive || window.matchMedia('(prefers-color-scheme: dark)').matches
  }
  $q.dark.set(isDark.value)

  // Events
  window.addEventListener('scroll', handleScroll)
  handleScroll()

  // Animations
  setupScrollAnimations()
  setupStatsObserver()
  startTypewriter()
  fetchProjects()
  fetchProjectsCount()
  fetchSocials()
  fetchEmail()
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  if (typewriterTimeout) clearTimeout(typewriterTimeout)
})

watch(isDark, (val) => {
  $q.dark.set(val)
  localStorage.setItem('darkMode', val.toString())
})
</script>

<style scoped>
/* ============ CSS VARIABLES ============ */
.portfolio-page {
  --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  --accent-gradient: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
  --card-bg: rgba(255, 255, 255, 0.7);
  --card-border: rgba(255, 255, 255, 0.3);
  --text-primary: #0f172a;
  --text-secondary: #475569;
  --text-muted: #94a3b8;
  --bg-primary: #ffffff;
  --bg-secondary: #f8fafc;
  --border-color: rgba(148, 163, 184, 0.2);
  --navbar-bg: rgba(255, 255, 255, 0.7);
  --transition-fast: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  --transition-med: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  --transition-slow: 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
  --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.08);
  --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.body--dark .portfolio-page {
  --card-bg: rgba(30, 30, 50, 0.6);
  --card-border: rgba(255, 255, 255, 0.1);
  --text-primary: #f1f5f9;
  --text-secondary: #cbd5e1;
  --text-muted: #64748b;
  --bg-primary: #0f172a;
  --bg-secondary: #1e293b;
  --border-color: rgba(148, 163, 184, 0.15);
  --navbar-bg: rgba(15, 23, 42, 0.7);
  --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.3);
  --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.4);
  --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.5);
}

.portfolio-page {
  font-family: 'Inter', 'Roboto', sans-serif;
  background: var(--bg-primary);
  color: var(--text-primary);
  transition: background-color var(--transition-med), color var(--transition-med);
  overflow-x: hidden;
}

/* ============ SCROLL PROGRESS ============ */
.scroll-progress-bar {
  position: fixed;
  top: 0;
  left: 0;
  height: 3px;
  background: var(--primary-gradient);
  z-index: 9999;
  transition: width 0.1s linear;
  box-shadow: 0 0 10px rgba(102, 126, 234, 0.5);
}

/* ============ NAVBAR ============ */
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  padding: 16px 0;
  background: transparent;
  backdrop-filter: blur(0px);
  transition: all var(--transition-med);
}

.navbar.scrolled {
  background: var(--navbar-bg);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  padding: 10px 0;
  box-shadow: var(--shadow-sm);
  border-bottom: 1px solid var(--border-color);
}

.navbar-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  user-select: none;
}

.logo-mark {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: var(--primary-gradient);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 800;
  font-size: 20px;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
  transition: transform var(--transition-fast);
}

.logo:hover .logo-mark {
  transform: rotate(-8deg) scale(1.05);
}

.logo-text {
  font-size: 20px;
  font-weight: 700;
  color: var(--text-primary);
}

.nav-links {
  display: flex;
  gap: 8px;
}

.nav-links a {
  padding: 8px 16px;
  border-radius: 10px;
  color: var(--text-secondary);
  text-decoration: none;
  font-weight: 500;
  font-size: 15px;
  transition: all var(--transition-fast);
  position: relative;
}

.nav-links a:hover {
  color: var(--text-primary);
  background: var(--bg-secondary);
}

.nav-links a.active {
  color: white;
  background: var(--primary-gradient);
}

.nav-actions {
  display: flex;
  align-items: center;
  gap: 8px;
}

.theme-toggle {
  transition: transform var(--transition-fast);
}

.theme-toggle:hover {
  transform: rotate(20deg);
}

.hire-btn {
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.mobile-menu-btn {
  display: none;
}

@media (max-width: 768px) {
  .nav-links,
  .hire-btn {
    display: none;
  }
  .mobile-menu-btn {
    display: inline-flex;
  }
}

.mobile-menu {
  width: 280px;
}

/* ============ HERO ============ */
.hero-section {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 100px 24px 160px;
  overflow: hidden;
}

.hero-bg {
  position: absolute;
  inset: 0;
  overflow: hidden;
  z-index: 0;
}

.blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.4;
  animation: blobFloat 20s infinite ease-in-out;
}

.body--dark .blob {
  opacity: 0.3;
}

.blob-1 {
  width: 500px;
  height: 500px;
  background: #667eea;
  top: -150px;
  left: -150px;
  animation-delay: 0s;
}

.blob-2 {
  width: 450px;
  height: 450px;
  background: #764ba2;
  bottom: -100px;
  right: -100px;
  animation-delay: -7s;
}

.blob-3 {
  width: 400px;
  height: 400px;
  background: #06b6d4;
  top: 30%;
  right: 10%;
  animation-delay: -14s;
}

@keyframes blobFloat {
  0%,
  100% {
    transform: translate(0, 0) scale(1);
  }
  33% {
    transform: translate(50px, -60px) scale(1.1);
  }
  66% {
    transform: translate(-40px, 40px) scale(0.95);
  }
}

.grid-overlay {
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(var(--border-color) 1px, transparent 1px),
    linear-gradient(90deg, var(--border-color) 1px, transparent 1px);
  background-size: 50px 50px;
  mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
  -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
  opacity: 0.4;
}

.hero-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
  text-align: center;
  opacity: 0;
  transform: translateY(30px);
  transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
}

.hero-content.animate-in {
  opacity: 1;
  transform: translateY(0);
}

.hero-chip {
  margin-bottom: 24px;
  font-weight: 500;
}

.hero-title {
  font-size: clamp(2.5rem, 6vw, 4.5rem);
  font-weight: 800;
  line-height: 1.1;
  margin: 0 0 16px;
  color: var(--text-primary);
  letter-spacing: -0.02em;
}

.gradient-text {
  background: var(--primary-gradient);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.typewriter-container {
  font-size: clamp(1.25rem, 3vw, 1.75rem);
  font-weight: 600;
  color: var(--text-secondary);
  margin-bottom: 24px;
  min-height: 2.5em;
}

.typewriter-prefix {
  color: var(--text-secondary);
}

.typewriter-text {
  color: #667eea;
  font-weight: 700;
}

.body--dark .typewriter-text {
  color: #a78bfa;
}

.typewriter-cursor {
  display: inline-block;
  color: #667eea;
  font-weight: 300;
  animation: cursorBlink 1s infinite;
  margin-left: 2px;
}

.body--dark .typewriter-cursor {
  color: #a78bfa;
}

@keyframes cursorBlink {
  0%,
  50% {
    opacity: 1;
  }
  51%,
  100% {
    opacity: 0;
  }
}

.hero-description {
  font-size: 1.125rem;
  line-height: 1.7;
  color: var(--text-secondary);
  max-width: 600px;
  margin: 0 auto 40px;
}

.hero-description strong {
  color: var(--text-primary);
  font-weight: 600;
}

.hero-actions {
  display: flex;
  gap: 16px;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 60px;
}

.btn-primary-grad {
  background: var(--primary-gradient);
  color: white;
  box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
  transition: all var(--transition-fast);
}

.btn-primary-grad:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 32px rgba(102, 126, 234, 0.5);
}

.stats-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
  gap: 16px;
  max-width: 700px;
  margin: 0 auto;
}

.stat-card {
  padding: 24px 16px;
  text-align: center;
  border-radius: 16px;
  background: var(--card-bg);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid var(--card-border);
  box-shadow: var(--shadow-sm);
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 0.8s forwards;
}

.stat-value {
  font-size: 2rem;
  font-weight: 800;
  background: var(--primary-gradient);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  line-height: 1;
  margin-bottom: 4px;
}

.stat-suffix {
  font-size: 1.5rem;
}

.stat-label {
  font-size: 0.875rem;
  color: var(--text-secondary);
  font-weight: 500;
}

.scroll-indicator {
  position: absolute;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  text-align: center;
  cursor: pointer;
  opacity: 0.7;
  transition: opacity var(--transition-fast);
  z-index: 2;
}

.scroll-indicator:hover {
  opacity: 1;
}

.scroll-indicator span {
  display: block;
  font-size: 0.75rem;
  color: var(--text-muted);
  margin-bottom: 8px;
  letter-spacing: 0.1em;
  text-transform: uppercase;
}

.scroll-mouse {
  width: 24px;
  height: 40px;
  border: 2px solid var(--text-muted);
  border-radius: 12px;
  margin: 0 auto;
  position: relative;
}

.scroll-dot {
  width: 4px;
  height: 8px;
  background: var(--text-muted);
  border-radius: 2px;
  position: absolute;
  top: 8px;
  left: 50%;
  transform: translateX(-50%);
  animation: scrollDown 2s infinite;
}

@keyframes scrollDown {
  0% {
    transform: translate(-50%, 0);
    opacity: 1;
  }
  100% {
    transform: translate(-50%, 16px);
    opacity: 0;
  }
}

/* ============ SECTIONS ============ */
.section {
  padding: 100px 24px;
  position: relative;
}

.section-alt {
  background: var(--bg-secondary);
}

.section-container {
  max-width: 1200px;
  margin: 0 auto;
}

.section-header {
  text-align: center;
  margin-bottom: 60px;
}

.section-subtitle {
  display: inline-block;
  font-size: 0.875rem;
  font-weight: 600;
  color: #667eea;
  text-transform: uppercase;
  letter-spacing: 0.15em;
  margin-bottom: 12px;
}

.section-title {
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 800;
  color: var(--text-primary);
  margin: 0 0 20px;
  letter-spacing: -0.02em;
}

.section-divider {
  width: 80px;
  height: 4px;
  background: var(--primary-gradient);
  margin: 0 auto;
  border-radius: 2px;
}

[data-animate] {
  opacity: 0;
  transform: translateY(40px);
  transition: opacity var(--transition-slow), transform var(--transition-slow);
}

[data-animate].animate-in {
  opacity: 1;
  transform: translateY(0);
}

/* ============ GLASS CARD ============ */
.glass-card {
  background: var(--card-bg);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid var(--card-border);
  border-radius: 20px;
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-med);
}

.glass-card:hover {
  box-shadow: var(--shadow-md);
  transform: translateY(-4px);
}

/* ============ ABOUT ============ */
.about-grid {
  display: grid;
  grid-template-columns: 1fr 1.5fr;
  gap: 60px;
  align-items: center;
}

@media (max-width: 768px) {
  .about-grid {
    grid-template-columns: 1fr;
    gap: 40px;
  }
}

.avatar-wrapper {
  position: relative;
  width: 320px;
  height: 320px;
  margin: 0 auto;
  max-width: 100%;
}

.avatar-ring {
  position: absolute;
  inset: 0;
  border-radius: 50%;
  padding: 8px;
  background: var(--primary-gradient);
}

.avatar-inner {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: var(--bg-primary);
  display: flex;
  align-items: center;
  justify-content: center;
}

@keyframes rotate {
  to {
    transform: rotate(360deg);
  }
}

.avatar-badge {
  position: absolute;
  bottom: 20px;
  right: 20px;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: var(--bg-primary);
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: var(--shadow-md);
  border: 3px solid var(--bg-primary);
}

.orbit {
  position: absolute;
  border: 1px dashed var(--border-color);
  border-radius: 50%;
  animation: orbit 15s linear infinite;
}

.orbit-1 {
  inset: -20px;
}

.orbit-2 {
  inset: -40px;
  animation-duration: 25s;
  animation-direction: reverse;
}

@keyframes orbit {
  to {
    transform: rotate(360deg);
  }
}

.about-heading {
  font-size: 2rem;
  font-weight: 800;
  color: var(--text-primary);
  margin: 0 0 20px;
  letter-spacing: -0.02em;
}

.about-paragraph {
  font-size: 1.0625rem;
  line-height: 1.8;
  color: var(--text-secondary);
  margin-bottom: 16px;
}

.about-paragraph strong {
  color: var(--text-primary);
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
  margin: 30px 0;
}

.info-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  background: var(--bg-secondary);
  border-radius: 12px;
  transition: all var(--transition-fast);
}

.info-item:hover {
  transform: translateX(4px);
  background: var(--card-bg);
}

.info-label {
  font-size: 0.75rem;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 2px;
}

.info-value {
  font-weight: 600;
  color: var(--text-primary);
}

.languages-section {
  margin-top: 20px;
}

/* ============ SKILLS ============ */
.skill-tabs {
  display: flex;
  justify-content: center;
  margin-bottom: 40px;
  flex-wrap: wrap;
}

.skill-toggle {
  background: var(--card-bg);
  border-radius: 50px;
  padding: 4px;
  border: 1px solid var(--card-border);
}

.skills-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 20px;
  margin-bottom: 60px;
}

.skill-card {
  padding: 24px;
  text-align: center;
  border-radius: 20px;
  transition: all var(--transition-med);
}

.skill-card:hover {
  transform: translateY(-6px) scale(1.02);
}

.skill-icon-wrapper {
  width: 64px;
  height: 64px;
  margin: 0 auto 16px;
  border-radius: 16px;
  background: var(--primary-gradient);
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
  transition: transform var(--transition-fast);
}

.skill-card:hover .skill-icon-wrapper {
  transform: rotate(-8deg) scale(1.1);
}

.skill-icon-wrapper .q-icon {
  color: white !important;
}

.skill-name {
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 12px;
  font-size: 0.95rem;
}

.skill-bar {
  margin-top: 8px;
}

.skill-bars-wrapper {
  max-width: 800px;
  margin: 0 auto;
  padding: 40px;
  background: var(--card-bg);
  border-radius: 20px;
  border: 1px solid var(--card-border);
  backdrop-filter: blur(20px);
}

.progress-bars {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.progress-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 8px;
}

.progress-label {
  font-weight: 600;
  color: var(--text-primary);
}

.progress-value {
  font-weight: 700;
  color: #667eea;
}

.progress-track {
  height: 10px;
  background: var(--bg-secondary);
  border-radius: 10px;
  overflow: hidden;
}

.progress-fill {
  height: 100%;
  background: var(--primary-gradient);
  border-radius: 10px;
  transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
}

.progress-fill::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    90deg,
    transparent,
    rgba(255, 255, 255, 0.3),
    transparent
  );
  animation: shimmerMove 2s infinite;
}

@keyframes shimmerMove {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
}

/* Skill transition group */
.skill-fade-enter-active,
.skill-fade-leave-active {
  transition: all 0.4s ease;
}

.skill-fade-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.skill-fade-leave-to {
  opacity: 0;
  transform: scale(0.9);
}

/* ============ TIMELINE ============ */
.timeline {
  position: relative;
  max-width: 900px;
  margin: 0 auto;
  padding: 40px 0;
}

.timeline::before {
  content: '';
  position: absolute;
  top: 0;
  bottom: 0;
  left: 50%;
  width: 2px;
  background: linear-gradient(
    to bottom,
    transparent,
    #667eea 10%,
    #764ba2 90%,
    transparent
  );
  transform: translateX(-50%);
}

@media (max-width: 768px) {
  .timeline::before {
    left: 20px;
  }
}

.timeline-item {
  position: relative;
  width: 50%;
  padding: 0 40px 60px;
  opacity: 0;
  animation: fadeInTimeline 0.8s forwards;
}

@keyframes fadeInTimeline {
  to {
    opacity: 1;
  }
}

.timeline-item.left {
  left: 0;
  text-align: right;
  padding-right: 60px;
  padding-left: 0;
}

.timeline-item.right {
  left: 50%;
  padding-left: 60px;
  padding-right: 0;
}

@media (max-width: 768px) {
  .timeline-item {
    width: 100%;
    left: 0 !important;
    padding-left: 60px !important;
    padding-right: 20px !important;
    text-align: left !important;
  }
}

.timeline-marker {
  position: absolute;
  top: 10px;
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: var(--primary-gradient);
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 0 0 8px var(--bg-primary), 0 4px 12px rgba(102, 126, 234, 0.4);
  z-index: 2;
}

.timeline-item.left .timeline-marker {
  right: -24px;
}

.timeline-item.right .timeline-marker {
  left: -24px;
}

@media (max-width: 768px) {
  .timeline-marker {
    left: -4px !important;
    right: auto !important;
  }
}

.timeline-content {
  padding: 24px;
  border-radius: 16px;
}

.timeline-period {
  display: inline-block;
  padding: 4px 12px;
  background: var(--primary-gradient);
  color: white;
  font-size: 0.75rem;
  font-weight: 600;
  border-radius: 20px;
  margin-bottom: 12px;
}

.timeline-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--text-primary);
  margin: 0 0 4px;
}

.timeline-company {
  font-size: 0.875rem;
  color: var(--text-secondary);
  font-weight: 500;
}

.timeline-duties {
  margin: 0;
  padding-left: 20px;
  text-align: left;
}

.timeline-duties li {
  margin-bottom: 8px;
  color: var(--text-secondary);
  font-size: 0.9rem;
  line-height: 1.6;
}

/* Goals */
.goals-wrapper {
  margin-top: 60px;
}

.goals-card {
  padding: 20px;
}

.goals-header {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 24px;
}

.goals-icon {
  width: 56px;
  height: 56px;
  border-radius: 16px;
  background: var(--primary-gradient);
  display: flex;
  align-items: center;
  justify-content: center;
}

.goals-icon .q-icon {
  color: white !important;
}

.goals-title {
  font-size: 1.5rem;
  font-weight: 700;
  margin: 0;
  color: var(--text-primary);
}

.goals-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
}

.goal-item {
  display: flex;
  gap: 12px;
  padding: 16px;
  background: var(--bg-secondary);
  border-radius: 12px;
  transition: all var(--transition-fast);
}

.goal-item:hover {
  transform: translateY(-2px);
  background: var(--card-bg);
}

.goal-text {
  color: var(--text-secondary);
  font-size: 0.9rem;
  line-height: 1.5;
}

/* ============ PROJECTS ============ */
.filter-bar {
  display: flex;
  gap: 8px;
  justify-content: center;
  margin-bottom: 40px;
  flex-wrap: wrap;
}

.projects-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 24px;
}

.project-card-wrapper {
  opacity: 0;
  animation: fadeInUp 0.6s forwards;
}

.project-card {
  height: 100%;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.project-header-gradient {
  height: 4px;
  background: var(--primary-gradient);
}

.project-body {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.project-icon {
  width: 56px;
  height: 56px;
  border-radius: 16px;
  background: var(--primary-gradient);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 16px;
  box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
  transition: transform var(--transition-fast);
}

.project-card:hover .project-icon {
  transform: rotate(-8deg) scale(1.1);
}

.project-name {
  font-size: 1.15rem;
  font-weight: 700;
  color: var(--text-primary);
  margin: 0 0 12px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.project-desc {
  color: var(--text-secondary);
  font-size: 0.9rem;
  line-height: 1.6;
  margin-bottom: 20px;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  min-height: 4.8em;
}

.project-meta {
  display: flex;
  gap: 16px;
  padding-top: 16px;
  border-top: 1px solid var(--border-color);
  margin-top: auto;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 4px;
  font-size: 0.8rem;
  color: var(--text-muted);
  font-weight: 500;
}

.project-actions {
  padding: 12px 16px 16px;
}

/* Shimmer skeleton */
.shimmer {
  background: linear-gradient(
    90deg,
    var(--bg-secondary) 0%,
    var(--card-border) 50%,
    var(--bg-secondary) 100%
  );
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
  border-radius: 6px;
}

.body--dark .shimmer {
  background: linear-gradient(
    90deg,
    rgba(100, 116, 139, 0.1) 0%,
    rgba(100, 116, 139, 0.2) 50%,
    rgba(100, 116, 139, 0.1) 100%
  );
  background-size: 200% 100%;
}

@keyframes shimmer {
  0% {
    background-position: 200% 0;
  }
  100% {
    background-position: -200% 0;
  }
}

.shimmer-row {
  display: flex;
  gap: 12px;
  align-items: center;
}

.shimmer-circle {
  width: 56px;
  height: 56px;
  border-radius: 16px;
  flex-shrink: 0;
}

.shimmer-lines {
  flex: 1;
}

.shimmer-line {
  height: 12px;
  margin-bottom: 8px;
}

.w-100 {
  width: 100%;
}
.w-90 {
  width: 90%;
}
.w-80 {
  width: 80%;
}
.w-60 {
  width: 60%;
}
.w-40 {
  width: 40%;
}

.shimmer-tags {
  display: flex;
  gap: 8px;
}

.shimmer-tag {
  width: 60px;
  height: 20px;
  border-radius: 10px;
}

/* Empty State */
.empty-state {
  text-align: center;
  padding: 80px 20px;
}

.empty-icon {
  width: 120px;
  height: 120px;
  margin: 0 auto 24px;
  border-radius: 50%;
  background: var(--bg-secondary);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text-muted);
}

.empty-icon.error {
  background: #fee2e2;
  color: #dc2626;
}

.empty-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--text-primary);
  margin: 0 0 12px;
}

.empty-text {
  color: var(--text-secondary);
  margin-bottom: 24px;
}

/* ============ CONTACT ============ */
.contact-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: start;
}

@media (max-width: 768px) {
  .contact-grid {
    grid-template-columns: 1fr;
    gap: 40px;
  }
}

.contact-heading {
  font-size: clamp(1.75rem, 3vw, 2.25rem);
  font-weight: 800;
  color: var(--text-primary);
  margin: 0 0 20px;
  line-height: 1.2;
}

.contact-text {
  font-size: 1.0625rem;
  line-height: 1.7;
  color: var(--text-secondary);
  margin-bottom: 30px;
}

.contact-methods {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.contact-method {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 16px 20px;
  text-decoration: none;
  color: inherit;
  border-radius: 16px;
}

.contact-method-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  flex-shrink: 0;
}

.contact-method-icon.email {
  background: linear-gradient(135deg, #f43f5e, #ec4899);
}
.contact-method-icon.github {
  background: linear-gradient(135deg, #1f2937, #4b5563);
}
.contact-method-icon.linkedin {
  background: linear-gradient(135deg, #0077b5, #00a0dc);
}
.contact-method-icon.instagram {
  background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
}

.contact-method-label {
  font-size: 0.75rem;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 2px;
}

.contact-method-value {
  font-weight: 600;
  color: var(--text-primary);
  font-size: 0.95rem;
}

.contact-form-card {
  padding: 10px;
}

.form-title {
  font-size: 1.5rem;
  font-weight: 700;
  margin: 0 0 24px;
  color: var(--text-primary);
}

/* ============ FOOTER ============ */
.site-footer {
  background: var(--bg-secondary);
  border-top: 1px solid var(--border-color);
  padding: 60px 24px 30px;
}

.footer-container {
  max-width: 1200px;
  margin: 0 auto;
}

.footer-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
  flex-wrap: wrap;
  gap: 20px;
}

.footer-tagline {
  color: var(--text-secondary);
  margin: 12px 0 0;
  font-size: 0.9rem;
}

.footer-socials {
  display: flex;
  gap: 8px;
}

.footer-socials .q-btn {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  transition: all var(--transition-fast);
}

.footer-socials .q-btn:hover {
  background: var(--primary-gradient);
  color: white;
  transform: translateY(-2px);
}

.footer-separator {
  opacity: 0.5;
  margin-bottom: 24px;
}

.footer-bottom {
  text-align: center;
  color: var(--text-secondary);
  font-size: 0.875rem;
}

/* ============ ANIMATIONS ============ */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* ============ RESPONSIVE ============ */
@media (max-width: 600px) {
  .section {
    padding: 60px 16px;
  }
  .stats-row {
    grid-template-columns: repeat(2, 1fr);
  }
  .info-grid {
    grid-template-columns: 1fr;
  }
}

/* Smooth scroll */
html {
  scroll-behavior: smooth;
}

/* Selection */
::selection {
  background: #667eea;
  color: white;
}

/* Scrollbar */
.portfolio-page::-webkit-scrollbar {
  width: 10px;
}

.portfolio-page::-webkit-scrollbar-track {
  background: var(--bg-secondary);
}

.portfolio-page::-webkit-scrollbar-thumb {
  background: var(--primary-gradient);
  border-radius: 5px;
}
</style>