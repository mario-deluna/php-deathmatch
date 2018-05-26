#version 330 core
layout (location = 0) in vec3 position;
layout (location = 1) in vec3 normalv;
layout (location = 2) in vec2 text_coords;

uniform mat4 transform;
uniform mat4 view;
uniform mat4 projection;

out vec3 FragPos;
out vec3 FragNormals;
out vec2 tCoords;

void main()
{
    gl_Position = projection * view * transform * vec4(position, 1.0f);
    FragPos = vec3(transform * vec4(position, 1.0));
    FragNormals = mat3(transpose(inverse(transform))) * normalv;
    tCoords = text_coords;
}