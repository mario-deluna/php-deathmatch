#version 330 core

out vec4 fragment_color;

in vec3 FragPos;  
in vec3 FragNormals;
in vec2 tCoords;

uniform sampler2D texture1;
  
void main()
{
    vec4 textcol = texture(texture1, tCoords);
    vec3 lightPos = vec3(13.0, 13.0, 13.0); 
    vec3 lightColor = vec3(1.0, 1.0, 0.9);
    vec3 objectColor = vec3(0.7, 0.7, 0.7) * vec3(textcol.x, textcol.y, textcol.z);
    vec3 cameraPos = vec3(0.0, 0.0, -10.0);
    
    // ambient
    float ambientStrength = 0.5;
    vec3 ambient = ambientStrength * lightColor;
    
    // diffuse 
    vec3 norm = normalize(FragNormals);
    vec3 lightDir = normalize(lightPos - FragPos * 0.1);
    float diff = max(dot(norm, lightDir), 0.0);
    vec3 diffuse = diff * lightColor;
            
    vec3 result = (ambient + diffuse) * objectColor;
    fragment_color = vec4(result, 1.0);
} 