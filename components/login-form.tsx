"use client";

import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import { Suspense } from "react";
import { AuthError } from "@/components/shared/auth-error";
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import {
  Field,
  FieldDescription,
  FieldGroup,
  FieldLabel,
} from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import Link from "next/link";
import { login } from "@/app/actions/auth-actions";
import { useState } from "react";
import { Eye, EyeClosed } from "lucide-react";

export function LoginForm({
  className,
  ...props
}: React.ComponentProps<"div">) {
  const [passwordVisible, setPasswordVisible] = useState(false);

  const togglePasswordVisibility = () => {
    return setPasswordVisible(() => !passwordVisible);
  };
  return (
    <div className={cn("flex flex-col gap-6", className)} {...props}>
      <Card>
        <CardHeader>
          <CardTitle>Login to your account</CardTitle>
          <CardDescription>
            Enter your email below to login to your account
          </CardDescription>
        </CardHeader>
        <CardContent>
          <Suspense
            fallback={
              <div className="h-10 w-full animate-pulse bg-gray-100 mb-4 rounded" />
            }
          >
            <AuthError />
          </Suspense>
          <form method="POST">
            <FieldGroup>
              <Field>
                <FieldLabel htmlFor="email">Email</FieldLabel>
                <Input
                  id="email"
                  name="email"
                  type="email"
                  placeholder="m@example.com"
                  required
                />
              </Field>
              <Field>
                <div className="flex items-center">
                  <FieldLabel htmlFor="password">Password</FieldLabel>
                  <a
                    href="#"
                    className="ml-auto inline-block text-sm underline-offset-4 hover:underline"
                  >
                    Forgot your password?
                  </a>
                </div>
                <div className="flex flex-row">
                  <Input
                    id="password"
                    name="password"
                    type={passwordVisible ? "text" : "password"}
                    required
                  />
                  <Button
                    className="w-20"
                    type="button"
                    onClick={togglePasswordVisibility}
                  >
                    {passwordVisible ? <Eye /> : <EyeClosed />}
                  </Button>
                </div>
              </Field>
              <Field>
                <Button type="submit" formAction={login}>
                  Login
                </Button>
                <Button variant="outline" type="button">
                  Login with Google
                </Button>
                <FieldDescription className="text-center">
                  Don&apos;t have an account?{" "}
                  <Link href="/register">Sign up</Link>
                </FieldDescription>
              </Field>
            </FieldGroup>
          </form>
        </CardContent>
      </Card>
    </div>
  );
}
