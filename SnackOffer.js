import React, { useState } from "react";
import {
  Card,
  Image,
  Text,
  Badge,
  Button,
  Group,
  Input,
  InputWrapper,
  Select,
  MultiSelect,
} from "@mantine/core";
import styles from "./OfferType.module.css";
import { useDisclosure } from "@mantine/hooks";
import { Modal } from "@mantine/core";
import { DateInput } from "@mantine/dates";

const SnackOffer = () => {
  const [mainModalOpened, { open: openMainModal, close: closeMainModal }] =
    useDisclosure(false);
  const [
    freeItemModalOpend,
    { open: openFreeItemModal, close: closeFreeItemModal },
  ] = useDisclosure(false);
  const [
    percentageModalOpened,
    { open: openPercentageModal, close: closePercentageModal },
  ] = useDisclosure(false);

  const [startDate, setStartDate] = useState("");
  const [expireDate, setExpireDate] = useState("");
  const [numberOfSnack, setNumberOfSnack] = useState("");
  const [numOfFreeItem, setNumberOfFreeItem] = useState("");
  const [disStartDate, setDisStartDate] = useState("");
  const [disEndDate, setDisEndDate] = useState("");
  const [disAmount, setDisAmount] = useState("");

  const handleFreeItemCreation = () => {
    if (!startDate || !expireDate || !numberOfSnack || !numOfFreeItem) {
      alert("Please fill in all required fields.");
    }
  };
  const handleDiscountCreation = () => {
    if (!disStartDate || !disEndDate || !disAmount) {
      alert("Please fill in all required fields.");
    }
  };

  return (
    <Card
      shadow="sm"
      padding="lg"
      radius="md"
      withBorder
      className={styles.container}
      style={{
        position: "relative",
        marginLeft: "160px",
        marginRight: "30px",
        alignSelf: "center",
      }}
    >
      <Card.Section component="b" href="">
        <Image
          src="../public/img/SOffer.jpeg"
          height="160px"
          width="400px"
          alt="SnackOffer"
        />
      </Card.Section>

      <Group justify="space-between" mt="md" mb="xs">
        <Text fw={500}>Create Snack offers</Text>
      </Group>

      <Text size="sm" c="dimmed"></Text>

      <Button
        fullWidth
        mt="md"
        radius="md"
        variant="gradient"
        gradient={{ from: "rgba(0, 0, 0, 1)", to: "pink", deg: 102 }}
        onClick={openMainModal}
      >
        Create
      </Button>
      <Modal opened={mainModalOpened} onClose={closeMainModal} title="">
        <Button
          size="compact-lg"
          variant="subtle"
          color="pink"
          style={{ marginBottom: "20px", display: "block" }}
          onClick={openFreeItemModal}
        >
          Offer for free item
        </Button>

        <Button
          size="compact-lg"
          variant="subtle"
          color="pink"
          style={{ marginTop: "20px", display: "block" }}
          onClick={openPercentageModal}
        >
          Discount on items
        </Button>
      </Modal>
      <Modal
        opened={freeItemModalOpend}
        onClose={closeFreeItemModal}
        title="Free item's offer"
      >
        <InputWrapper label="Start Date">
          <DateInput
            placeholder="input StartDate"
            value={startDate}
            onChange={setStartDate}
            withAsterisk
          />
        </InputWrapper>

        <InputWrapper label="Expire Date">
          <DateInput
            placeholder="input EndDate "
            value={expireDate}
            onChange={setExpireDate}
            withAsterisk
          />
        </InputWrapper>

        <InputWrapper label="Required Number">
          <Input
            placeholder="input the required number of snacks"
            value={numberOfSnack}
            onChange={setNumberOfSnack}
            withAsterisk
          />
        </InputWrapper>

        <InputWrapper label="Required Number">
          <Input
            placeholder="input the number of the free item, ex:1"
            value={numOfFreeItem}
            onChange={setNumberOfFreeItem}
            withAsterisk
          />
        </InputWrapper>
        <InputWrapper label="Select the Snack">
          <MultiSelect
            placeholder="Pick theSnack"
            data={["Popcorn", "Pizza", "Burger", "Drink", "else"]}
          />
        </InputWrapper>

        <Button
          variant="gradient"
          gradient={{ from: "pink", to: "grape", deg: 147 }}
          size="sm"
          color="white"
          radius="md"
          style={{ marginTop: "20px" }}
          onClick={handleFreeItemCreation}
        >
          Create
        </Button>
      </Modal>

      <Modal
        opened={percentageModalOpened}
        onClose={closePercentageModal}
        title="Discount %"
      >
        <InputWrapper label="Discount's Amount">
          <Input
            placeholder="10%"
            value={disAmount}
            onChange={(e) => setDisAmount(e.target.value)}
            withAsterisk
          />
        </InputWrapper>

        <InputWrapper label="Start Date">
          <DateInput
            placeholder="input StartDate"
            value={disStartDate}
            onChange={setDisStartDate}
            withAsterisk
          />
        </InputWrapper>

        <InputWrapper label="End Date">
          <DateInput
            placeholder="input EndDate "
            value={disEndDate}
            onChange={setDisEndDate}
            withAsterisk
          />
        </InputWrapper>

        <InputWrapper>
          <MultiSelect
            label="Snacks"
            placeholder="Pick Snacks to apply the discount on them"
            data={["Popcorn", "Drink", "Pizza", "Burger", "else"]}
          />
        </InputWrapper>
        <Button
          variant="gradient"
          gradient={{ from: "pink", to: "grape", deg: 147 }}
          size="sm"
          color="white"
          radius="md"
          style={{ marginTop: "20px" }}
          onClick={handleDiscountCreation}
        >
          Create
        </Button>
      </Modal>
    </Card>
  );
};
export default SnackOffer;
