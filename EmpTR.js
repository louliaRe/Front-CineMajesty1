import { useForm, isEmail, isInRange, hasLength } from "@mantine/form";
import {
  TextInput,
  Switch,
  Group,
  ActionIcon,
  Box,
  Text,
  Button,
  Code,
  Avatar,
} from "@mantine/core";
import { randomId } from "@mantine/hooks";
import { IconTrash } from "@tabler/icons-react";
import { Alert } from "@mantine/core";
import { IconInfoCircle } from "@tabler/icons-react";
import React, { useState } from "react";
import axios from "axios";

const EmpTR = ({ data }) => {
  const [sortParams, setSortParams] = useState({});

  const filterData = (data, query) => {
    if (!Array.isArray(data)) {
      return [];
    }
    // Implement your filtering logic here
    return data.filter((item) =>
      Object.keys(item).some((key) => {
        const value = item[key];
        return typeof value === "string" && value.toLowerCase().includes(query);
      })
    );
  };

  const sortData = (data, payload) => {
    const { sortBy } = payload;

    if (!sortBy) {
      return filterData(data, payload.search);
    }

    return filterData(
      [...data].sort((a, b) => {
        if (payload.reversed) {
          return b[sortBy].localeCompare(a[sortBy]);
        }

        return a[sortBy].localeCompare(b[sortBy]);
      }),
      payload.search
    );
  };

  const isNotEmpty = (value, errorMessage) => {
    if (!value || value.trim() === "") {
      return errorMessage;
    }
  };
  const [errorMessage, setErrorMessage] = useState("");

  const sortedData = sortData(data, sortParams);

  const fields = sortedData.map((item, index) => (
    <div key={index}>
      <p>{item.name}</p>
    </div>
  ));

  const form = useForm({
    initialValues: {
      employees: [
        {
          avatar:
            "https://raw.githubusercontent.com/mantinedev/mantine/master/.demo/avatars/avatar-1.png",
          FirstName: "",
          LastName: " ",
          email: "",
          key: randomId(),
        },
      ],
    },
    validate: {
      FirstName: hasLength(
        { min: 2, max: 10 },
        "Name must be 2-10 characters long"
      ),
      LastName: hasLength(
        { min: 2, max: 10 },
        "Name must be 2-10 characters long"
      ),
      email: [isEmail("Invalid email")],
    },
  });

  const formFields = form.values.employees.map((item, index) => (
    <Group key={item.key} mt="xs">
      <Avatar src={item.avatar} alt="no image here" />
      <TextInput
        placeholder="First name"
        withAsterisk
        style={{ flex: 1 }}
        {...form.getInputProps(`employees.${index}.FirstName`)}
      />

      <TextInput
        placeholder="Doe"
        style={{ flex: 1 }}
        withAsterisk
        {...form.getInputProps(`employees.${index}.LastName`)}
      />

      <TextInput
        placeholder="rob_wolf@gmail.com"
        withAsterisk
        style={{ flex: 1 }}
        {...form.getInputProps(`employees.${index}.email`)}
      />
      <ActionIcon
        color="red"
        onClick={() => {
          if (
            window.confirm(
              `Are you sure you want to delete ${item.FirstName} ${item.LastName}?`
            )
          ) {
            form.removeListItem("employees", index);
          }
        }}
      >
        <IconTrash size="1px" />
      </ActionIcon>
    </Group>
  ));
  //function to handle the backend communication
  const saveEmployee = async (employee) => {
    try {
      //POST request to backend API endpoint
      const response = await axios.post("/api/employees", employee);
      headers: {
      }

      //handle the response
      console.log("Employee saved successfully:", response.data);
    } catch {
      console.errors("Error saving employee:", console.error.message);
    }
  };

  return (
    <div
      style={{
        display: "relative",
        marginLeft: "200px",
        alignItems: "flex-start",
        height: "100vh",
      }}
    >
      <TextInput
        placeholder="Search..."
        value={sortParams?.search} // Add a null check here
        onChange={(event) =>
          setSortParams((prevParams) => ({
            ...prevParams,
            search: event.currentTarget.value,
          }))
        }
      />
      <Box maw={500} mx="auto" component="form">
        {formFields.length > 0 ? (
          <Group justify="flex-end" mt="md" mb="xs">
            <Text
              fw={500}
              size="sm"
              style={{ flex: 1, cursor: "pointer" }}
              onClick={() =>
                setSortParams((prevParams) => ({
                  ...prevParams,
                  sortBy: "FirstName",
                  reversed: !prevParams.reversed,
                }))
              }
            >
              First Name
            </Text>
            <Text
              fw={500}
              size="sm"
              style={{ flex: 1, cursor: "pointer" }}
              onClick={() =>
                setSortParams((prevParams) => ({
                  ...prevParams,
                  sortBy: "LastName",
                  reversed: !prevParams.reversed,
                }))
              }
            >
              Last Name
            </Text>
            <Text fw={500} size="sm" pr={90}>
              Email
            </Text>
          </Group>
        ) : (
          <Text c="dimmed" ta="center">
            No one here...
          </Text>
        )}

        {formFields}

        <Group justify="center" mt="md">
          <Button
            variant="gradient"
            gradient={{ from: "rgba(0, 0, 0, 1)", to: "pink", deg: 102 }}
            onClick={async () => {
              const lastEmployee =
                form.values.employees[form.values.employees.length - 1];
              if (
                lastEmployee.FirstName &&
                lastEmployee.LastName &&
                lastEmployee.email
              ) {
                //save the last employee to the backEnd
                await saveEmployee(lastEmployee);
                form.insertListItem("employees", {
                  avatar: "",
                  FirstName: "",
                  LastName: "",
                  email: "",
                  key: randomId(),
                });
              } else {
                setErrorMessage("All fields must be filled");
              }
            }}
          >
            Add employee
          </Button>

          {errorMessage && (
            <Alert
              variant="light"
              color="pink"
              radius="lg"
              title="There is an empty field!"
              onClose={() => setErrorMessage("")}
            >
              {errorMessage}
            </Alert>
          )}
        </Group>
      </Box>
    </div>
  );
};
export default EmpTR;
