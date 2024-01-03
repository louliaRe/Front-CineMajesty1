import { useState } from "react";
import { UnstyledButton, Tooltip, Title } from "@mantine/core";
import {
  IconHome2,
  IconGauge,
  IconDeviceDesktopAnalytics,
  IconFingerprint,
  IconCalendarStats,
  IconUser,
  IconSettings,
} from "@tabler/icons-react";
import { MantineLogo } from "@mantine/ds";
import classes from "./DoubleNavbar.module.css";

const mainLinksMockdata = [
  { icon: IconHome2, label: "Home" },
  { icon: IconGauge, label: "Dashboard" },

  { icon: IconUser, label: "Account" },

  { icon: IconSettings, label: "Settings" },
];

const linksMockdata = ["Settings", "Dashboard", "Account", "Clients"];

//selected on before we start
const DoubleNavbar = () => {
  const [active, setActive] = useState("Releases");
  const [activeLink, setActiveLink] = useState("Settings");

  const mainLinks = mainLinksMockdata.map((link) => (
    <Tooltip
      label={link.label}
      position="right"
      withArrow
      transitionProps={{ duration: 0 }}
      key={link.label}
    >
      <UnstyledButton
        onClick={() => setActive(link.label)}
        className={classes.mainLink}
        data-active={link.label === active || undefined}
      >
        <link.icon style={{ width: 22, height: 22 }} stroke={1.5} />
      </UnstyledButton>
    </Tooltip>
  ));

  const links = linksMockdata.map((link) => (
    <a
      className={classes.link}
      data-active={activeLink === link || undefined}
      href="#"
      onClick={(event) => {
        event.preventDefault();
        setActiveLink(link);
      }}
      key={link}
    >
      {link}
    </a>
  ));

  return (
    <nav className={classes.navbar}>
      <div className={classes.wrapper}>
        <div className={classes.aside}>
          <div className={classes.logo}>
            <img
              src="myapp/public/img/logo.jpg"
              alt="logo"
              style={{ width: "30px", height: "30px" }}
            />
          </div>
          {mainLinks}
        </div>
        <div className={classes.main}>
          <Title order={4} className={classes.title}>
            {active}
          </Title>

          {links}
        </div>
      </div>
    </nav>
  );
};
export default DoubleNavbar;
