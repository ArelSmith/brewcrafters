import React from "react";
import { syncProfile } from "@/services/profile-services";

const Dashboard = async () => {
  await syncProfile();
  return <div>Ini Dashboard</div>;
};

export default Dashboard;
