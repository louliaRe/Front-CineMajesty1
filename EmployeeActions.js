import {
  Card,
  Text,
  SimpleGrid,
  UnstyledButton,
  Group,
  useMantineTheme,
  color,
} from "@mantine/core";
import {
  IconCreditCard,
  IconDiscount2,
  IconToolsKitchen2,
  IconVideoPlus,
  IconCalendarTime,
} from "@tabler/icons-react";

import classes from "./EmployeeActions.module.css";

const mockdata = [
  { title: "Credit cards", icon: IconCreditCard, color: "violet" },
  { title: "Add Movie", icon: IconVideoPlus, color: "cyan" },
  { title: "Add Snack", icon: IconToolsKitchen2, color: "blue" },
  { title: "Add offer", icon: IconDiscount2, color: "grape" },
  { title: " movie's schedule", icon: IconCalendarTime, color: "pink" },
];

export function EmployeeActions() {
  const theme = useMantineTheme();

  const items = mockdata.map((item) => (
    <UnstyledButton key={item.title} className={classes.item}>
      <item.icon color={theme.colors[item.color][6]} size={45} />
      <Text size="sm" mt={9}>
        {item.title}
      </Text>
    </UnstyledButton>
  ));

  return (
    <>
      <h2 style={{ marginTop: "20px", marginBottom: "80px" }}>
        Welcome Back , {classes.User}!!
        <br />
        Let's achieve our goals for today!!
      </h2>

      <Card withBorder radius="xl" mt="md" className={classes.card}>
        <Group justify="space-between">
          <Text className={classes.title} style={{ color: "violte" }}>
            Services
          </Text>
        </Group>
        <SimpleGrid cols={3} mt="md">
          {items}
        </SimpleGrid>
      </Card>
    </>
  );
}
export default EmployeeActions;
