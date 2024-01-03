import React, { useState } from "react";
import {
  Card,
  Image,
  Text,
  Badge,
  Button,
  Group,
  InputWrapper,
  Input,
} from "@mantine/core";
import styles from "./OfferType.module.css";
import { useDisclosure } from "@mantine/hooks";
import { Modal } from "@mantine/core";
import { DateInput } from "@mantine/dates";

const ShowOffer = () => {
  const [opened, { open, close }] = useDisclosure(false);
  const [amount, setAmount] = useState("");
  const [startDate, setStartDate] = useState(null);
  const [EndDate, setEndDate] = useState(null);
  const [showTimeId, setShowTimeId] = useState("");
  const handleCreateShowOffer = () => {
    console.log("Offer created:", { amount, startDate, EndDate, showTimeId });
  };
  return (
    <Card
      shadow="sm"
      padding="lg"
      radius="md"
      withBorder
      className={styles.container}
      style={{ position: "relative", marginLeft: "60px", alignSelf: "center" }}
    >
      <Card.Section component="a" href="">
        <Image
          src="../public/img/ShowOffer.jpeg"
          height="160px"
          width="400px"
          alt="ShowOffer"
        />
      </Card.Section>

      <Group justify="space-between" mt="md" mb="xs">
        <Text fw={500}>Create show offers</Text>
      </Group>

      <Text size="sm" c="dimmed"></Text>

      <Button
        fullWidth
        mt="md"
        radius="md"
        variant="gradient"
        gradient={{ from: "rgba(0, 0, 0, 1)", to: "pink", deg: 102 }}
        onClick={open}
      >
        Create
      </Button>
      <Modal opened={opened} onClose={close} title="Create Show offer">
        <InputWrapper label="Offer's Amount">
          <Input
            placeholder="Enter the Amount"
            value={amount}
            onChange={(e) => setAmount(e.target.value)}
            withAsterisk
          />
        </InputWrapper>

        <InputWrapper label="Start Date">
          <DateInput
            placeholder="input StartDate"
            value={startDate}
            onChange={setStartDate}
            withAsterisk
          />
        </InputWrapper>

        <InputWrapper label="End Date">
          <DateInput
            placeholder="input EndDate "
            value={EndDate}
            onChange={setEndDate}
            withAsterisk
          />
        </InputWrapper>

        <InputWrapper label="Show Time ID">
          <Input
            placeholder="Enter ShowTime ID"
            value={showTimeId}
            onChange={(e) => setShowTimeId(e.target.showTimeId)}
            withAsterisk
          />
        </InputWrapper>

        <Button
          size="md"
          variant="gradient"
          gradient={{ from: "pink", to: "grape", deg: 147 }}
          onClick={handleCreateShowOffer}
        >
          Create
        </Button>
      </Modal>
    </Card>
  );
};
export default ShowOffer;
