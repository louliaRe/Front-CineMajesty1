import {
  TextInput,
  Code,
  UnstyledButton,
  Badge,
  Text,
  Group,
  ActionIcon,
  Tooltip,
  rem,
} from "@mantine/core";
import {
  IconBulb,
  IconUser,
  IconCheckbox,
  IconSearch,
  IconPlus,
} from "@tabler/icons-react";
import { UserButton } from "./UserButton";
import classes from "./EmpNavbar.module.css";

const links = [
  { icon: IconBulb, label: "Activity" },
  { icon: IconCheckbox, label: "Tasks" },
  { icon: IconUser, label: "Contacts" },
];

const collections = [
  { emoji: "👍", label: "Sales" },
  { emoji: "💸", label: "Offers" },
  { emoji: "🛒", label: "Orders" },
  { emoji: "💁‍♀️", label: "Customers" },
];

const EmpNavbar = () => {
  const mainLinks = links.map((link) => (
    <UnstyledButton key={link.label} className={classes.mainLink}>
      <div className={classes.mainLinkInner}>
        <link.icon size={20} className={classes.mainLinkIcon} stroke={1.5} />
        <span>{link.label}</span>
      </div>
      {link.notifications && (
        <Badge size="sm" variant="filled" className={classes.mainLinkBadge}>
          {link.notifications}
        </Badge>
      )}
    </UnstyledButton>
  ));

  const collectionLinks = collections.map((collection) => (
    <a
      href="#"
      onClick={(event) => event.preventDefault()}
      key={collection.label}
      className={classes.collectionLink}
    >
      <span style={{ marginRight: 16, fontSize: 20 }}>{collection.emoji}</span>{" "}
      {collection.label}
    </a>
  ));

  return (
    <nav className={classes.navbar}>
      <div className={classes.section}>
        <UserButton  />
      </div>

      <TextInput
        placeholder="Search"
        size="md"
        leftSection={
          <IconSearch style={{ width: 12, height: 12 }} stroke={1.5} />
        }
        rightSectionWidth={70}
        rightSection={<Code className={classes.searchCode}>Ctrl + K</Code>}
        styles={{ section: { pointerEvents: "none" } }}
        mb="sm"
      />

      <div className={classes.section}>
        <div className={classes.mainLinks}>{mainLinks}</div>
      </div>

      <div className={classes.section}>
        <Group className={classes.collectionsHeader} justify="space-between">
          <Text size="xs" fw={500} c="dimmed">
            Collections
          </Text>
          <Tooltip label="Create collection" withArrow position="right">
            <ActionIcon variant="default" size={18}>
              <IconPlus style={{ width: 12, height: 12 }} stroke={1.5} />
            </ActionIcon>
          </Tooltip>
        </Group>
        <div className={classes.collections}>{collectionLinks}</div>
      </div>
    </nav>
  );
};
export default EmpNavbar;
