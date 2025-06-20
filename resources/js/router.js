import Inicio from "./components/Inicio.vue";
import StudentsList from "./components/StudentsList.vue";
import ProfessorsList from "./components/ProfessorsList.vue";
import SubjectsList from "./components/SubjectsList.vue";
import CareersList from "./components/CareersList.vue";
import EnrollmentsList from "./components/EnrollmentsList.vue";
import Login from "./components/auth/Login.vue";
import Register from "./components/auth/Register.vue";
import UsersList from "./components/UsersList.vue";
import DashboardStudents from "./components/students/DashboardStudents.vue";
import DashboardProfessors from "./components/professors/DashboardProfessors.vue";  

export const routes = [
    { path: "/login", component: Login, meta: { guest: true } },
    { path: "/register", component: Register, meta: { guest: true } },
    { path: "/inicio", component: Inicio, meta: { requiresAuth: true } },
    {
        path: "/students",
        name: "Students",
        component: StudentsList,
        meta: { requiresAuth: true },
    },
    {
        path: "/professors",
        name: "Professors",
        component: ProfessorsList,
        meta: { requiresAuth: true },
    },
    {
        path: "/subjects",
        name: "Subjects",
        component: SubjectsList,
        meta: { requiresAuth: true },
    },
    {
        path: "/careers",
        name: "Careers",
        component: CareersList,
        meta: { requiresAuth: true },
    },
    {
        path: "/enrollments",
        name: "Enrollments",
        component: EnrollmentsList,
        meta: { requiresAuth: true },
    },
    {
        path: "/users",
        name: "Users",
        component: UsersList,
        meta: { requiresAuth: true },
    },
    {
        path: "/dashboard-students",
        name: "DashboardStudents",
        component: DashboardStudents,
        meta: { requiresAuth: true },
    },
    {
        path: "/dashboard-professors",
        name: "DashboardProfessors",
        component: DashboardProfessors,
        meta: { requiresAuth: true },
    },
];
