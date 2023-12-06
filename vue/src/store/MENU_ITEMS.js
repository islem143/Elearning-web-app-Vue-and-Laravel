export const  TEACHER_MENU=[
    {
      label: "Home",
      items: [
        {
          label: "Dashboard",
          icon: "pi pi-fw pi-home",
          to: "/teacher",
        },
      ],
    },
    {
      label: "Modules",
      items: [
        {
          label: "Modules",
          icon: "pi pi-fw pi-bookmark",
          to: "/teacher/modules",
        },
      ],
    },
  ];

  export const  ADMIN_MENU=[
    {
      label: "Home",
      items: [
        {
          label: "Dashboard",
          icon: "pi pi-fw pi-home",
          to: "/admin",
        },
      ],
    },
    {
      label: "Users",
      items: [
        {
          label: "List",
          icon: "pi pi-fw pi-user",
          to: "/admin/users",
        },
      ],
    },
    {
        label: "Log",
        items: [
          {
            label: "History",
            icon: "pi pi-fw pi-user",
            to: "/history",
          },
        ],
      },
  ];  

  export const  STUDENT_MENU=[
    {
      label: "Home",
      items: [
        {
          label: "Dashboard",
          icon: "pi pi-fw pi-home",
          to: "/",
        },
      ],
    },
    {
      label: "Modules",
      items: [
        {
          label: "Modules",
          icon: "pi pi-fw pi-bookmark",
          to: "/modules/list",
        },
        {
          label: "My Modules",
          icon: "pi pi-fw pi-bookmark",
          to: "/modules/mylist",
        },
      ],
    },
    
  ];  