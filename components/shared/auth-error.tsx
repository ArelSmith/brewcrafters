"use client";

import { useSearchParams } from "next/navigation";
import { AlertCircle } from "lucide-react";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { useRouter } from "next/navigation";
import { usePathname } from "next/navigation";
import { useEffect } from "react";

export function AuthError() {
  const searchParams = useSearchParams();
  const error = searchParams.get("error");
  const pathname = usePathname();
  const message = searchParams.get("message");
  const router = useRouter();

  useEffect(() => {
    if (error || message) {
      const timeout = setTimeout(() => {
        router.replace(pathname);
      }, 5000);

      return () => clearTimeout(timeout);
    }
  }, [error, message, router, pathname]);

  if (error) {
    return (
      <Alert variant="destructive" className="mb-4">
        <AlertCircle className="h-4 w-4" />
        <AlertTitle>Waduh, Gagal!</AlertTitle>
        <AlertDescription>{error}</AlertDescription>
      </Alert>
    );
  }

  if (message) {
    return (
      <Alert className="mb-4 border-green-500 text-green-700 bg-green-50">
        <AlertCircle className="h-4 w-4 text-green-600" />
        <AlertTitle>Mantap!</AlertTitle>
        <AlertDescription>{message}</AlertDescription>
      </Alert>
    );
  }

  return null;
}
