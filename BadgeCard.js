import React from "react";
import { MDCRipple } from "@material/ripple";
import {
  Card,
  Image,
  Button,
  Menu,
  Group,
  Text,
  Badge,
  useMantineTheme,
  ActionIcon,
} from "@mantine/core";
import { Link } from "react-router-dom";
import classes from "./BadgeCard.module.css";
import EmployeesTable from "./EmployeesTable";

const mockdata = {
  image: <Image src="./public/img/manager.jpg" alt="Manager" />,
  title: "Employees",
  Activities: "Add/ Delete/ Edit",

  badges: [
    { emoji: "➕", label: "Add" },
    { emoji: "❌", label: "Delete" },
    { emoji: "✏️", label: "Edit" },
    { emoji: "☑️", label: "Check" },
  ],
};

export function BadgeCard() {
  const { image, title, Activities, badges } = mockdata;
  const features = badges.map((badge) => (
    <Badge
      variant="light"
      key={badge.label}
      leftSection={badge.emoji}
      color="pink"
    >
      {badge.label}
    </Badge>
  ));

  return (
    <Card withBorder radius="md" p="md" className={classes.card}>
      <Card.Section>
        <Image src={image} alt={title} height={180} />
      </Card.Section>

      <Card.Section className={classes.section} mt="md">
        <Group justify="apart">
          <Text fz="lg" fw={500}>
            {title}
          </Text>
          <Badge size="sm" variant="light" color="pink">
            {Activities}
          </Badge>
        </Group>
      </Card.Section>

      <Card.Section className={classes.section}>
        <Group gap={7} mt={5}>
          {features}
        </Group>
      </Card.Section>

      <Group mt="xs">
        <div>
          <Link to="/employees-list">
            <Button radius="xl" color="pink" style={{ flex: 1 }}>
              Show Employees List
            </Button>
          </Link>
        </div>
      </Group>
    </Card>
  );
}

//to make this component available
export default BadgeCard;
