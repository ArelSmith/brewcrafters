"use client";

import { register } from "@/app/actions/auth-actions";
import { Button } from "@/components/ui/button";
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
import { Suspense } from "react";
import { AuthError } from "./shared/auth-error";
import { useState } from "react";
import { Eye, EyeClosed } from "lucide-react";

export function SignupForm({ ...props }: React.ComponentProps<typeof Card>) {
  const [passwordVisible, setPasswordVisible] = useState(false);

  const togglePasswordVisibility = () => [
    setPasswordVisible((visible) => !visible),
  ];
  return (
    <Card {...props}>
      <CardHeader>
        <CardTitle>Create an account</CardTitle>
        <CardDescription>
          Enter your information below to create your account
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
        <form>
          <FieldGroup>
            <Field>
              <FieldLabel htmlFor="name">Username</FieldLabel>
              <Input
                id="name"
                name="username"
                type="text"
                placeholder="John Doe"
                required
              />
            </Field>
            <Field>
              <FieldLabel htmlFor="email">Email</FieldLabel>
              <Input
                id="email"
                name="email"
                type="email"
                placeholder="m@example.com"
                required
              />
              <FieldDescription>
                We&apos;ll use this to contact you. We will not share your email
                with anyone else.
              </FieldDescription>
            </Field>
            <Field>
              <FieldLabel htmlFor="password">Password</FieldLabel>
              <span className="flex flex-row">
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
              </span>
              <FieldDescription>
                Must be at least 8 characters long.
              </FieldDescription>
            </Field>
            <Field>
              <FieldLabel htmlFor="confirm-password">
                Confirm Password
              </FieldLabel>
              <Input
                id="confirm-password"
                name="confirm-password"
                type={passwordVisible ? "text" : "password"}
                required
              />
              <FieldDescription>Please confirm your password.</FieldDescription>
            </Field>
            <FieldGroup>
              <Field>
                <Button formAction={register} type="submit">
                  Create Account
                </Button>
                <Button variant="outline" type="button">
                  Sign up with Google
                </Button>
                <FieldDescription className="px-6 text-center">
                  Already have an account? <Link href="/login">Sign in</Link>
                </FieldDescription>
              </Field>
            </FieldGroup>
          </FieldGroup>
        </form>
      </CardContent>
    </Card>
  );
}
