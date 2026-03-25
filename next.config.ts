import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  images: {
    remotePatterns: [
      {
        protocol: "https",
        hostname: "dummyimage.com", // Daftarin si dummyimage di sini
        port: "",
        pathname: "/**", // Izinin semua folder/path di dalemnya
      },
    ],
  },
};

export default nextConfig;
