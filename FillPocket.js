import React, { useState } from "react";
import axios from "axios";
import {
  Input,
  Button,
  Notification,
  Grid,
  Title,
  BackgroundImage,
} from "@mantine/core";

const FillPocket = () => {
  const [customerId, setCustomerId] = useState("");
  const [customerName, setCustomerName] = useState("");
  const [amount, setAmount] = useState("");
  const [notification, setNotification] = useState("");

  const HandleFillWallet = async () => {
    try {
      //Send data
      const response = await axios.post("/api/fill-wallet", {
        customerId,
        amount,
        customerName,
      });

      setNotification({
        color: "teal",
        title: "Wallet Filled",
        message: `Successfully filled wallet for Customer ID: ${customerId} `,
      });

      // Clear form fields
      setCustomerId("");
      setCustomerName("");
      setAmount("");
      console.log(response.data);
    } catch (error) {
      console.error("Error filling wallet: ", error);

      setNotification({
        color: "red",
        title: "Error",
        message: `Failed to fill wallet. Please try again.`,
      });
    }
  };
  return (
    <>
      <BackgroundImage></BackgroundImage>
      <Grid
        style={{
          position: "relative",
          right: "50%",
          left: "30%",
          marginTop: "30%",
        }}
      >
        <Grid.Col span={6} style={{ marginBottom: "50px" }}>
          <Title
            order={2}
            orderMd={1}
            align="center"
            style={{ fontStyle: "italic" }}
          >
            Let's Fill Customer's wallet
          </Title>
        </Grid.Col>

        <Grid.Col span={8} style={{ marginBottom: 16 }}>
          <Input
            label="Customer ID"
            placeholder="Enter Customer ID"
            value={customerId}
            onChange={(e) => setCustomerId(e.target.value)}
          />
        </Grid.Col>

        <Grid.Col span={8} style={{ marginBottom: 16 }}>
          <Input
            label="Customer Name"
            placeholder="Enter Customer Name"
            value={customerName}
            onChange={(e) => setCustomerName(e.target.value)}
          />
        </Grid.Col>

        <Grid.Col span={8} style={{ marginBottom: 16 }}>
          <Input
            label="Amount"
            placeholder="Enter Amount"
            value={amount}
            onChange={(e) => setAmount(e.target.value)}
          />
        </Grid.Col>

        <Grid.Col span={5} style={{ marginBottom: 16 }}>
          <Button
            size="lg"
            variant="gradient"
            gradient={{ from: "pink", to: "grape", deg: 147 }}
            onClick={HandleFillWallet}
          >
            Fill Wallet
          </Button>
        </Grid.Col>
        {notification && (
          <Notification
            color={notification.color}
            title={notification.title}
            onClose={() =>
              setNotification(null) && setCustomerId(null) && setAmount(null)
            }
          >
            {notification.message}
          </Notification>
        )}
      </Grid>
    </>
  );
};
export default FillPocket;
