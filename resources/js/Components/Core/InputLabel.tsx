import { LabelHTMLAttributes } from 'react';

export default function InputLabel({
    value,
    className = '',
    children,
    ...props
}: LabelHTMLAttributes<HTMLLabelElement> & { value?: string }) {
    return (
        <label
            {...props}
            className={
                `fieldset ` +
                className
            }
        >
            <span className={"fieldset-legend"}>{value ? value : children}</span>
        </label>
    );
}
